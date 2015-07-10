/*
*  by zhanxp
*/

(function ($) {

    $.extend($.fn, {
        // http://docs.jquery.com/Plugins/Validation/validate
        validate: function (options) {

            // if nothing is selected, return nothing; can't chain anyway
            if (!this.length) {
                options && options.debug && window.console && console.warn("nothing selected, can't validate, returning nothing");
                return;
            }

            // check if a validator for this form was already created
            var validator = $.data(this[0], 'validator');
            if (validator) {
                return validator;
            }

            validator = new $.validator(options, this[0]);
            $.data(this[0], 'validator', validator);

            if (validator.settings.onsubmit) {

                // allow suppresing validation by adding a cancel class to the submit button
                this.find("input, button").filter(".cancel").click(function () {
                    validator.cancelSubmit = true;
                });

                // when a submitHandler is used, capture the submitting button
                if (validator.settings.submitHandler) {
                    this.find("input, button").filter(":submit").click(function () {
                        validator.submitButton = this;
                    });
                }

                // validate the form on submit
                this.submit(function (event) {
                    if (validator.settings.debug)
                    // prevent form submit to be able to see console output
                        event.preventDefault();


                    function handle() {
                        if (validator.settings.submitHandler) {
                            if (validator.submitButton) {
                                // insert a hidden input as a replacement for the missing submit button
                                var hidden = $("<input type='hidden'/>").attr("name", validator.submitButton.name).val(validator.submitButton.value).appendTo(validator.currentForm);
                            }
                            validator.settings.submitHandler.call(validator, validator.currentForm);
                            if (validator.submitButton) {
                                // and clean up afterwards; thanks to no-block-scope, hidden can be referenced
                                hidden.remove();
                            }
                            return false;
                        }
                        return true;
                    }

                    // prevent submit for invalid forms or custom submit handlers
                    if (validator.cancelSubmit) {
                        validator.cancelSubmit = false;
                        return handle();
                    }
                    if (validator.form()) {
                        if (validator.pendingRequest) {
                            validator.formSubmitted = true;
                            return false;
                        }
                        return handle();
                    } else {
                        validator.focusInvalid();
                        return false;
                    }
                });
            }

            return validator;
        },
        // http://docs.jquery.com/Plugins/Validation/valid
        valid: function () {
            if ($(this[0]).is('form')) {
                return this.validate().form();
            } else {
                var valid = true;
                var validator = $(this[0].form).validate();
                this.each(function () {
                    valid &= validator.element(this);
                });
                return valid;
            }
        },
        // attributes: space seperated list of attributes to retrieve and remove
        removeAttrs: function (attributes) {
            var result = {},
			$element = this;
            $.each(attributes.split(/\s/), function (index, value) {
                result[value] = $element.attr(value);
                $element.removeAttr(value);
            });
            return result;
        },
        // http://docs.jquery.com/Plugins/Validation/rules
        rules: function (command, argument) {
            var element = this[0];

            if (command) {
                var settings = $.data(element.form, 'validator').settings;
                var staticRules = settings.rules;
                var existingRules = $.validator.staticRules(element);
                switch (command) {
                    case "add":
                        $.extend(existingRules, $.validator.normalizeRule(argument));
                        staticRules[element.name] = existingRules;
                        if (argument.messages)
                            settings.messages[element.name] = $.extend(settings.messages[element.name], argument.messages);
                        break;
                    case "remove":
                        if (!argument) {
                            delete staticRules[element.name];
                            return existingRules;
                        }
                        var filtered = {};
                        $.each(argument.split(/\s/), function (index, method) {
                            filtered[method] = existingRules[method];
                            delete existingRules[method];
                        });
                        return filtered;
                }
            }

            var data = $.validator.normalizeRules(
		$.extend(
			{},
			$.validator.metadataRules(element),
			$.validator.classRules(element),
			$.validator.attributeRules(element),
			$.validator.staticRules(element)
		), element);

            // make sure required is at front
            //if (data.required) {
            //var param = data.required;
            //delete data.required;
            //data = $.extend({ required: param }, data);
            //}

            return data;
        }
    });

    // Custom selectors
    $.extend($.expr[":"], {
        // http://docs.jquery.com/Plugins/Validation/blank
        blank: function (a) { return !$.trim("" + a.value); },
        // http://docs.jquery.com/Plugins/Validation/filled
        filled: function (a) { return !!$.trim("" + a.value); },
        // http://docs.jquery.com/Plugins/Validation/unchecked
        unchecked: function (a) { return !a.checked; }
    });

    // constructor for validator
    $.validator = function (options, form) {
        this.settings = $.extend({}, $.validator.defaults, options);
        this.currentForm = form;
        this.init();
    };


    $.validator.format = function (source, params) {
        if (arguments.length == 1)
            return function () {
                var args = $.makeArray(arguments);
                args.unshift(source);
                return $.validator.format.apply(this, args);
            };
        if (arguments.length > 2 && params.constructor != Array) {
            params = $.makeArray(arguments).slice(1);
        }
        if (params.constructor != Array) {
            params = [params];
        }
        $.each(params, function (i, n) {
            source = source.replace(new RegExp("\\{" + i + "\\}", "g"), n);
        });
        return source;
    };

    // zhanxp
    $.extend($.validator, {

        defaults: {
            messages: {},
            groups: {},
            rules: {},
            tips: {},
            errorClass: "form-tip text-danger",
            validClass: "form-tip text-success",
            tipClass: "form-tip text-info",
            errorElement: "span",
            focusInvalid: true,
            errorContainer: $([]),
            errorLabelContainer: $([]),
            onsubmit: true,
            ignore: [],
            ignoreTitle: false,
            alertError: true,
            //errorPlacement: function(error, element) {
            //if (error.size() > 0) {
            //var name = $(element).attr("name");
            //var obj = $("#" + name.replace(".", "_") + "_validationMessage");
            //obj.attr("class", error[0].classList[0]);
            //obj.text(error[0].childNodes[0].wholeText);
            //}
            //},
            onfocusin: function (element) {
                this.lastActive = element;
                this.tipsFor(element);
            },
            onfocusout: function (element) {
                this.element(element);
                if (this.invalidElements && (element in this.invalidElements)) {
                    var label = this.errorsFor(element);
                    if (label.length > 0)
                        label.removeClass().addClass(errorClass);
                }
                if (this.validElements && (element in this.validElements)) {
                    var label = this.errorsFor(element);
                    if (label.length > 0)
                        label.removeClass().addClass(validClass);
                }
            },
            onkeyup: function (element) {

            },
            onclick: function (element) {
                if (element.name in this.submitted)
                    this.element(element);
                else if (element.parentNode.name in this.submitted)
                    this.element(element.parentNode);
            },
            highlight: function (element, errorClass, validClass) {
                var label = this.errorsFor(element);
                if (label.length > 0)
                    label.addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function (element, errorClass, validClass) {
                var label = this.errorsFor(element);
                if (label.length > 0)
                    label.removeClass(errorClass).addClass(validClass);
            }
        },

        // http://docs.jquery.com/Plugins/Validation/Validator/setDefaults
        setDefaults: function (settings) {
            $.extend($.validator.defaults, settings);
        },

        messages: {
            required: "必须填写该项！",
            remote: "填写的值无效！",
            email: "请填写正确的Email地址！",
            url: "  请填写正确的Url地址！",
            date: "请填写正确的日期！",
            dateISO: "请填写格式如：1990-01-01 的日期格式！",
            number: "只能填写数字！",
            digits: "只能填写整数！",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "两次输入的值不相等！",
            accept: "请选择符合要求的文件",
            maxlength: $.validator.format("最多输入{0}个字符！"),
            minlength: $.validator.format("请最少输入{0}个字符！"),
            rangelength: $.validator.format("请输入{0}-{1}个字符！"),
            range: $.validator.format("请输入介于{0}-{1}的值！"),
            max: $.validator.format("请输入大于{0}的值！"),
            min: $.validator.format("请输入小于{0}的值！")
        },

        autoCreateRanges: false,

        prototype: {

            init: function () {
                this.labelContainer = $(this.settings.errorLabelContainer);
                this.errorContext = this.labelContainer.length && this.labelContainer || $(this.currentForm);
                this.containers = $(this.settings.errorContainer).add(this.settings.errorLabelContainer);
                this.submitted = {};
                this.valueCache = {};
                this.pendingRequest = 0;
                this.pending = {};
                this.invalid = {};
                this.reset();

                var groups = (this.groups = {});
                $.each(this.settings.groups, function (key, value) {
                    $.each(value.split(/\s/), function (index, name) {
                        groups[name] = key;
                    });
                });
                var rules = this.settings.rules;
                $.each(rules, function (key, value) {
                    rules[key] = $.validator.normalizeRule(value);
                });
                function delegate(event) {
                    var validator = $.data(this[0].form, "validator");
                    validator.settings["on" + event.type] && validator.settings["on" + event.type].call(validator, this[0]);
                }
                $(this.currentForm)
				.mydelegate("focusin focusout keyup", ":text, :password, :file, select, textarea", delegate)
				.mydelegate("click", ":radio, :checkbox, select, option", delegate);

                if (this.settings.invalidHandler)
                    $(this.currentForm).bind("invalid-form.validate", this.settings.invalidHandler);
            },

            // http://docs.jquery.com/Plugins/Validation/Validator/form
            form: function () {
                this.checkForm();
                $.extend(this.submitted, this.errorMap);
                this.invalid = $.extend({}, this.errorMap);
                var valid = this.valid();
                this.showErrors();
                if (!this.valid()) {
                    $(this.currentForm).triggerHandler("invalid-form", [this]);
                    this.showAlertErrors();
                    return false;
                }
                return true;
            },

            checkForm: function () {
                this.prepareForm();
                for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
                    this.check(elements[i]);
                }
                return this.valid();
            },

            // http://docs.jquery.com/Plugins/Validation/Validator/element
            element: function (element) {
                element = this.clean(element);
                this.lastElement = element;
                this.prepareElement(element);
                this.currentElements = $(element);
                var result = this.check(element);
                if (result) {
                    delete this.invalid[element.name];
                } else {
                    this.invalid[element.name] = true;
                }
                if (!this.numberOfInvalids()) {
                    // Hide error containers on last error
                    this.toHide = this.toHide.add(this.containers);
                }
                this.showErrors();
                return result;
            },
            showAlertErrors: function (errors) {
                if (this.settings.alertError) {
                    var haveError = [];
                    for (var i = 0; this.errorList[i]; i++) {
                        var error = this.errorList[i];
                        if (!error)
                            continue;
                        var ii = haveError.length;
                        var have = false;
                        while (ii--) {
                            if (haveError[ii] === error.message) {
                                have = true;
                            }
                        }
                        if (!have)
                            haveError.push(error.message);
                    }
                    if (haveError.length > 0)
                        alert(haveError.join("\r\n"));
                }
            },
            // http://docs.jquery.com/Plugins/Validation/Validator/showErrors
            showErrors: function (errors) {
                if (errors) {
                    // add items to error list and map
                    $.extend(this.errorMap, errors);
                    this.errorList = [];
                    for (var name in errors) {
                        this.errorList.push({
                            message: errors[name],
                            element: this.findByName(name)[0]
                        });
                    }
                    // remove items from success list
                    this.successList = $.grep(this.successList, function (element) {
                        return !(element.name in errors);
                    });
                }

                this.settings.showErrors
				? this.settings.showErrors.call(this, this.errorMap, this.errorList)
				: this.defaultShowErrors();
            },

            // http://docs.jquery.com/Plugins/Validation/Validator/resetForm
            resetForm: function () {
                if ($.fn.resetForm)
                    $(this.currentForm).resetForm();
                this.submitted = {};
                this.prepareForm();
                this.hideErrors();
                this.elements().removeClass(this.settings.errorClass);
            },

            numberOfInvalids: function () {
                return this.objectLength(this.invalid);
            },

            objectLength: function (obj) {
                var count = 0;
                for (var i in obj)
                    count++;
                return count;
            },

            hideErrors: function () {
                this.addWrapper(this.toHide).hide();
            },

            valid: function () {
                return this.size() == 0;
            },

            size: function () {
                return this.errorList.length;
            },

            focusInvalid: function () {
                if (this.settings.focusInvalid) {
                    try {
                        $(this.findLastActive() || this.errorList.length && this.errorList[0].element || []).filter(":visible").focus();
                    } catch (e) {
                        // ignore IE throwing errors when focusing hidden elements
                    }
                }
            },

            findLastActive: function () {
                var lastActive = this.lastActive;
                return lastActive && $.grep(this.errorList, function (n) {
                    return n.element.name == lastActive.name;
                }).length == 1 && lastActive;
            },

        	elements: function() {
    			var validator = this,
    				rulesCache = {};

    			// select all valid inputs inside the form (no submit or reset buttons)
    			return $(this.currentForm)
    			.find("input, select, textarea")
    			.not(":submit, :reset, :image, [disabled]")
    			.not( this.settings.ignore )
    			.filter(function() {
    				!this.name && validator.settings.debug && window.console && console.error( "%o has no name assigned", this);

    				// select only the first element for each name, and only those with rules specified
    				if ( this.name in rulesCache || !validator.objectLength($(this).rules()) )
    					return false;

    				rulesCache[this.name] = true;
    				return true;
    			});
    		},

            clean: function (selector) {
                return $(selector)[0];
            },

            errors: function () {
                return $(this.settings.errorElement + "." + this.settings.errorClass, this.errorContext);
            },

            reset: function () {
                this.successList = [];
                this.errorList = [];
                this.errorMap = {};
                this.toShow = $([]);
                this.toHide = $([]);
                this.currentElements = $([]);
            },

            prepareForm: function () {
                this.reset();
                this.toHide = this.errors().add(this.containers);
            },

            prepareElement: function (element) {
                this.reset();
                this.toHide = this.errorsFor(element);
            },

            check: function (element) {
                element = this.clean(element);
                // if radio/checkbox, validate first element in group instead
                if (this.checkable(element)) {
                    element = this.findByName(element.name)[0];
                }

                if ($(element).attr("type") == "text") {
                    //去除空格
                    var thisVal = $.trim($(element).val());
                    $(element).val(thisVal);
                }

                var rules = $(element).rules();
                var dependencyMismatch = false;
                var breakvalidate = false;
                for (method in rules) {
                    var rule = { method: method, parameters: rules[method] };
                    try {
                        var result = $.validator.methods[method].call(this, element.value.replace(/\r/g, ""), element, rule.parameters);
                        if (result == "break-validate") {
                            breakvalidate = true;
                            break;
                        }

                        // if a method indicates that the field is optional and therefore valid,
                        // don't mark it as valid when there are no other rules
                        if (result == "dependency-mismatch") {
                            dependencyMismatch = true;
                            continue;
                        }

                        dependencyMismatch = false;


                        if (result == "pending") {
                            this.toHide = this.toHide.not(this.errorsFor(element));
                            return;
                        }

                        if (!result) {
                            this.formatAndAdd(element, rule);
                            return false;
                        }

                    } catch (e) {
                        this.settings.debug && window.console && console.log("exception occured when checking element " + element.name
						 + ", check the '" + rule.method + "' method", e);
                        throw e;
                    }
                }
                if (breakvalidate) {
                    return;
                }

                if (dependencyMismatch)
                    return;

                if (this.objectLength(rules))
                    this.successList.push(element);

                return true;
            },

            // return the custom message for the given element and validation method
            // specified in the element's "messages" metadata
            customMetaMessage: function (element, method) {
                if (!$.metadata)
                    return;

                var meta = this.settings.meta
				? $(element).metadata()[this.settings.meta]
				: $(element).metadata();

                return meta && meta.messages && meta.messages[method];
            },

            // return the custom message for the given element name and validation method
            customMessage: function (name, method) {
                var m = this.settings.messages[name];
                return m && (m.constructor == String
				? m
				: m[method]);
            },

            //zhanxp
            customTip: function (element) {
                var name = element.name;
                var m = this.settings.tips[name];
                if (m) {
                	 return m.tips;
                }
                else {
                	return "";
                }
                    
            },
            //zhanxp
            customSucceedMessage: function (element) {
                var name = element.name;
                var m = this.settings.tips[name];
                if (m && m.SucceedMessage) {
                	return m.SucceedMessage;
                }   
                else {
                	return "";
                }      
            },

            // return the first defined argument, allowing empty strings
            findDefined: function () {
                for (var i = 0; i < arguments.length; i++) {
                    if (arguments[i] !== undefined)
                        return arguments[i];
                }
                return undefined;
            },

            defaultMessage: function (element, method) {
                return this.findDefined(
				this.customMessage(element.name, method),
				this.customMetaMessage(element, method),
                // title is never undefined, so handle empty string as undefined
				!this.settings.ignoreTitle && element.title || undefined,
				$.validator.messages[method],
				"<strong>Warning: No message defined for " + element.name + "</strong>"
			);
            },

            formatAndAdd: function (element, rule) {
                var message = this.defaultMessage(element, rule.method),
				theregex = /\$?\{(\d+)\}/g;
                if (typeof message == "function") {
                    message = message.call(this, rule.parameters, element);
                } else if (theregex.test(message)) {
                    message = jQuery.format(message.replace(theregex, '{$1}'), rule.parameters);
                }
                this.errorList.push({
                    message: message,
                    element: element
                });

                this.errorMap[element.name] = message;
                this.submitted[element.name] = message;
            },

            // zhanxp
            addWrapper: function (toToggle) {
                if (this.settings.wrapper)
                    toToggle = toToggle.add(toToggle.parent(this.settings.wrapper));
                return toToggle;
            },

            // zhanxp
            defaultShowErrors: function () {

                for (var i = 0; this.errorList[i]; i++) {
                    var error = this.errorList[i];
                    this.settings.highlight && this.settings.highlight.call(this, error.element, this.settings.errorClass, this.settings.validClass);
                    this.showLabel(error.element, error.message);
                }
                for (var i = 0; this.successList[i]; i++) {
                    this.showLabel(this.successList[i]);
                }
                if (this.errorList.length) {
                    this.toShow = this.toShow.add(this.containers);
                }
                if (this.settings.success) {
                    for (var i = 0; this.successList[i]; i++) {
                        this.showLabel(this.successList[i]);
                    }
                }
                if (this.settings.unhighlight) {
                    for (var i = 0, elements = this.validElements(); elements[i]; i++) {
                        this.settings.unhighlight.call(this, elements[i], this.settings.errorClass, this.settings.validClass);
                    }
                }
                this.toHide = this.toHide.not(this.toShow);
                //this.hideErrors();
                this.addWrapper(this.toShow).show();

            },

            validElements: function () {
                return this.currentElements.not(this.invalidElements());
            },

            invalidElements: function () {
                return $(this.errorList).map(function () {
                    return this.element;
                });
            },

            // zhanxp 
            showLabel: function (element, message) {
                var label = this.errorsFor(element);
                if (message) {
                    label.removeClass().addClass(this.settings.errorClass);
                    label.html(message);
                }
                else {
                    label.html(this.customSucceedMessage(element));
                    label.removeClass().addClass(this.settings.validClass);
                }
                this.toShow = this.toShow.add(label);
            },
            //zhanxp
            errorsFor: function (element) {
                var name = element.name;
                var m = this.settings.tips[name];
                if (m && m.groupName)
                    name = m.groupName;
                
                var tipsID = name + "_tips";
                return  $("#" + tipsID);
      
            },
            //zhanxp tip
            tipsFor: function (element) {
                var text = this.customTip(element);
                var label = this.errorsFor(element);
                if (label.length <= 0)
                    return;
				label.html(text);
                label.removeClass().addClass(this.settings.tipClass);
                label.show();
            },
            idOrName: function (element) {
                return this.groups[element.name] || (this.checkable(element) ? element.name : element.name || element.name);
            },

            checkable: function (element) {
                return /radio|checkbox/i.test(element.type);
            },

            findByName: function (name) {
                // select by name and filter by form for performance over form.find("[name=...]")
                var form = this.currentForm;
                return $(document.getElementsByName(name)).map(function (index, element) {
                    return element.form == form && element.name == name && element || null;
                });
            },

            getLength: function (value, element) {
                switch (element.nodeName.toLowerCase()) {
                    case 'select':
                        return $("option:selected", element).length;
                    case 'input':
                        if (this.checkable(element))
                            return this.findByName(element.name).filter(':checked').length;
                }
                // return value.length;
                return value.replace(/[^\x00-\xff]/g, "xx").length;
            },
            
            getLengthENCN: function (value, element) {
                switch (element.nodeName.toLowerCase()) {
                    case 'select':
                        return $("option:selected", element).length;
                    case 'input':
                        if (this.checkable(element))
                            return this.findByName(element.name).filter(':checked').length;
                }
                return value.length;
            },
            
            getBytesLen: function(str){  
            	var sum=0;  
            	for(var i=0;i<str.length;i++)  
            	{  
            		if ((str.charCodeAt(i)>=0) && (str.charCodeAt(i)<=255))  
            			sum=sum+1;  
            		else  
            			sum=sum+2;  
            	}  
            	return sum;
            },

            depend: function (param, element) {
                return this.dependTypes[typeof param]
				? this.dependTypes[typeof param](param, element)
				: true;
            },

            dependTypes: {
                "boolean": function (param, element) {
                    return param;
                },
                "string": function (param, element) {
                    return !!$(param, element.form).length;
                },
                "function": function (param, element) {
                    return param(element);
                }
            },

            optional: function (element) {
                return !$.validator.methods.required.call(this, $.trim(element.value), element) && "dependency-mismatch";
            },

            startRequest: function (element) {
                if (!this.pending[element.name]) {
                    this.pendingRequest++;
                    this.pending[element.name] = true;
                }
            },

            stopRequest: function (element, valid) {
                this.pendingRequest--;
                // sometimes synchronization fails, make sure pendingRequest is never < 0
                if (this.pendingRequest < 0)
                    this.pendingRequest = 0;
                delete this.pending[element.name];
                if (valid && this.pendingRequest == 0 && this.formSubmitted && this.form()) {
                    $(this.currentForm).submit();
                    this.formSubmitted = false;
                } else if (!valid && this.pendingRequest == 0 && this.formSubmitted) {
                    $(this.currentForm).triggerHandler("invalid-form", [this]);
                    this.formSubmitted = false;
                }
            },

            previousValue: function (element) {
                return $.data(element, "previousValue") || $.data(element, "previousValue", {
                    old: null,
                    valid: true,
                    message: this.defaultMessage(element, "remote")
                });
            }

        },

        classRuleSettings: {
            required: { required: true },
            email: { email: true },
            url: { url: true },
            date: { date: true },
            dateISO: { dateISO: true },
            dateDE: { dateDE: true },
            number: { number: true },
            numberDE: { numberDE: true },
            digits: { digits: true },
            creditcard: { creditcard: true }
        },

        addClassRules: function (className, rules) {
            className.constructor == String ?
			this.classRuleSettings[className] = rules :
			$.extend(this.classRuleSettings, className);
        },

        classRules: function (element) {
            var rules = {};
            var classes = $(element).attr('class');
            classes && $.each(classes.split(' '), function () {
                if (this in $.validator.classRuleSettings) {
                    $.extend(rules, $.validator.classRuleSettings[this]);
                }
            });
            return rules;
        },

        attributeRules: function (element) {
            var rules = {};
            var $element = $(element);

            for (method in $.validator.methods) {
                var value = $element.attr(method);
                if (value) {
                    rules[method] = value;
                }
            }

            // maxlength may be returned as -1, 2147483647 (IE) and 524288 (safari) for text inputs
            if (rules.maxlength && /-1|2147483647|524288/.test(rules.maxlength)) {
                delete rules.maxlength;
            }

            return rules;
        },

        metadataRules: function (element) {
            if (!$.metadata) return {};

            var meta = $.data(element.form, 'validator').settings.meta;
            return meta ?
			$(element).metadata()[meta] :
			$(element).metadata();
        },

        staticRules: function (element) {
            var rules = {};
            var validator = $.data(element.form, 'validator');
            if (validator.settings.rules) {
                rules = $.validator.normalizeRule(validator.settings.rules[element.name]) || {};
            }
            return rules;
        },

        normalizeRules: function (rules, element) {
            // handle dependency check
            $.each(rules, function (prop, val) {
                // ignore rule when param is explicitly false, eg. required:false
                if (val === false) {
                    delete rules[prop];
                    return;
                }
                if (val.param || val.depends) {
                    var keepRule = true;
                    switch (typeof val.depends) {
                        case "string":
                            keepRule = !!$(val.depends, element.form).length;
                            break;
                        case "function":
                            keepRule = val.depends.call(element, element);
                            break;
                    }
                    if (keepRule) {
                        rules[prop] = val.param !== undefined ? val.param : true;
                    } else {
                        delete rules[prop];
                    }
                }
            });

            // evaluate parameters
            $.each(rules, function (rule, parameter) {
                rules[rule] = $.isFunction(parameter) ? parameter(element) : parameter;
            });

            // clean number parameters
            $.each(['minlength', 'maxlength', 'min', 'max'], function () {
                if (rules[this]) {
                    rules[this] = Number(rules[this]);
                }
            });
            $.each(['rangelength', 'range','rangelengthENCN'], function () {
                if (rules[this]) {
                    rules[this] = [Number(rules[this][0]), Number(rules[this][1])];
                }
            });

            if ($.validator.autoCreateRanges) {
                // auto-create ranges
                if (rules.min && rules.max) {
                    rules.range = [rules.min, rules.max];
                    delete rules.min;
                    delete rules.max;
                }
                if (rules.minlength && rules.maxlength) {
                    rules.rangelength = [rules.minlength, rules.maxlength];
                    delete rules.minlength;
                    delete rules.maxlength;
                }
            }

            // To support custom messages in metadata ignore rule methods titled "messages"
            if (rules.messages) {
                delete rules.messages;
            }

            return rules;
        },

        // Converts a simple string to a {string: true} rule, e.g., "required" to {required:true}
        normalizeRule: function (data) {
            if (typeof data == "string") {
                var transformed = {};
                $.each(data.split(/\s/), function () {
                    transformed[this] = true;
                });
                data = transformed;
            }
            return data;
        },

        // http://docs.jquery.com/Plugins/Validation/Validator/addMethod
        addMethod: function (name, method, message) {
            $.validator.methods[name] = method;
            $.validator.messages[name] = message != undefined ? message : $.validator.messages[name];
            if (method.length < 3) {
                $.validator.addClassRules(name, $.validator.normalizeRule(name));
            }
        },

        methods: {

            // http://docs.jquery.com/Plugins/Validation/Methods/required
            required: function (value, element, param) {
                // check if dependency is met
                if (!this.depend(param, element))
                    return "dependency-mismatch";
                switch (element.nodeName.toLowerCase()) {
                    case 'select':
                        // could be an array for select-multiple or a string, both are fine this way
                        var val = $(element).val();
                        return val && val.length > 0;
                    case 'input':
                        if (this.checkable(element))
                            return this.getLength(value, element) > 0;
                    default:
                        return $.trim(value).length > 0;
                }
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/remote
            // http://docs.jquery.com/Plugins/Validation/Methods/remote
            remote: function (value, element, param) {
                if (this.optional(element))
                    return "dependency-mismatch";

                var previous = this.previousValue(element);
                if (!this.settings.messages[element.name])
                    this.settings.messages[element.name] = {};
                previous.originalMessage = this.settings.messages[element.name].remote;
                this.settings.messages[element.name].remote = previous.message;

                param = typeof param == "string" && { url: param} || param;

                if (previous.old !== value) {
                    previous.old = value;
                    var validator = this;
                    this.startRequest(element);
                    var data = "val=" + encodeURIComponent(value);
                    
                    var success = function (response) {
                        validator.settings.messages[element.name].remote = previous.originalMessage;
                        var valid = response === true;
                        if (valid) {
                            var submitted = validator.formSubmitted;
                            validator.prepareElement(element);
                            validator.formSubmitted = submitted;
                            validator.successList.push(element);
                            validator.showErrors();
                        } else {
                            var errors = {};
                            var message = (previous.message = response || validator.defaultMessage(element, "remote"));
                            errors[element.name] = $.isFunction(message) ? message(value) : message;
                            validator.showErrors(errors);
                        }
                        previous.valid = valid;
                        validator.stopRequest(element, valid);
                    };
                    
         
                    if(window.needCrossDomain && window.obpHost) {
            			  $.ajax({
                              url: window.obpHost + param.url,
                              mode: "abort",
                              port: "validate" + element.name,
                              dataType: "jsonp",
                              data:data,
                              success:success
                          });
            		}
            		else {
            			  $.ajax($.extend(true, {
                              url: param,
                              mode: "abort",
                              port: "validate" + element.name,
                              dataType: "json",
                              type: "POST",
                              data: data,
                              success:success
                          }, param));
            		}
                    
                    
                  
                    return "pending";
                } else if (this.pending[element.name]) {
                    return "pending";
                }
                return previous.valid;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/minlength
            minlength: function (value, element, param) {
                return this.optional(element) || this.getLength($.trim(value), element) >= param;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/maxlength
            maxlength: function (value, element, param) {
                return this.optional(element) || this.getLength($.trim(value), element) <= param;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/rangelength
            rangelength: function (value, element, param) {
                var length = this.getLength($.trim(value), element);
                return this.optional(element) || (length >= param[0] && length <= param[1]);
            },
            
            // http://docs.jquery.com/Plugins/Validation/Methods/rangelengthENCN
            rangelengthENCN: function (value, element, param) {
                var length = this.getLengthENCN($.trim(value), element);
                return this.optional(element) || (length >= param[0] && length <= param[1]);
            },
            
            // http://docs.jquery.com/Plugins/Validation/Methods/rangelengthENCN
            rangelengthENANDCN: function (value, element, param) {
            	 var regOne = /^[-a-zA-Z0-9]{1,63}$/;
            	 var regTwo = new RegExp(/^[-a-zA-Z0-9\u4E00-\u9FA5]{1,}$/);
            	 var length = this.getLengthENCN($.trim(value), element);
            	 if(regOne.test(value)){
            		 return this.optional(element) || (length >= 3 && length <= 63);
            	 }
            	 if(regTwo.test(value)){
            		 return this.optional(element) || (length >= 1 && length <= 40);
            	 } 
            },
            

            // http://docs.jquery.com/Plugins/Validation/Methods/min
            min: function (value, element, param) {
                return this.optional(element) || value >= param;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/max
            max: function (value, element, param) {
                return this.optional(element) || value <= param;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/range
            range: function (value, element, param) {
                return this.optional(element) || (value >= param[0] && value <= param[1]);
            },

            email: function (value, element) {
                var reg = new RegExp(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/);
                return this.optional(element) || reg.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/url
            url: function (value, element) {
                // contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
                return this.optional(element) || /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/date
            date: function (value, element) {
                return this.optional(element) || !/Invalid|NaN/.test(new Date(value));
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/dateISO
            dateISO: function (value, element) {
                return this.optional(element) || /^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/number
            number: function (value, element) {
                return this.optional(element) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/digits
            digits: function (value, element) {
                return this.optional(element) || /^\d+$/.test(value);
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/creditcard
            // based on http://en.wikipedia.org/wiki/Luhn
            creditcard: function (value, element) {
                if (this.optional(element))
                    return "dependency-mismatch";
                // accept only digits and dashes
                if (/[^0-9-]+/.test(value))
                    return false;
                var nCheck = 0,
				nDigit = 0,
				bEven = false;

                value = value.replace(/\D/g, "");

                for (var n = value.length - 1; n >= 0; n--) {
                    var cDigit = value.charAt(n);
                    var nDigit = parseInt(cDigit, 10);
                    if (bEven) {
                        if ((nDigit *= 2) > 9)
                            nDigit -= 9;
                    }
                    nCheck += nDigit;
                    bEven = !bEven;
                }

                return (nCheck % 10) == 0;
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/accept
            accept: function (value, element, param) {
                param = typeof param == "string" ? param.replace(/,/g, '|').replaceAll('image/','') : "png|jpe?g|gif";
                return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
            },

            // http://docs.jquery.com/Plugins/Validation/Methods/equalTo
            equalTo: function (value, element, param) {
                // bind to the blur event of the target in order to revalidate whenever the target field is updated
                // TODO find a way to bind the event just once, avoiding the unbind-rebind overhead
                var target = $(param).unbind(".validate-equalTo").bind("blur.validate-equalTo", function () {
                    $(element).valid();
                });
                return value == target.val();
            }

        }

    });

    // deprecated, use $.validator.format instead
    $.format = $.validator.format;

})(jQuery);

// ajax mode: abort
// usage: $.ajax({ mode: "abort"[, port: "uniqueport"]});
// if mode:"abort" is used, the previous request on that port (port can be undefined) is aborted via XMLHttpRequest.abort() 
; (function ($) {
    var ajax = $.ajax;
    var pendingRequests = {};
    $.ajax = function (settings) {
        // create settings for compatibility with ajaxSetup
        settings = $.extend(settings, $.extend({}, $.ajaxSettings, settings));
        var port = settings.port;
        if (settings.mode == "abort") {
            if (pendingRequests[port]) {
                pendingRequests[port].abort();
            }
            return (pendingRequests[port] = ajax.apply(this, arguments));
        }
        return ajax.apply(this, arguments);
    };
})(jQuery);

// provides cross-browser focusin and focusout events
// IE has native support, in other browsers, use event caputuring (neither bubbles)

// provides delegate(type: String, delegate: Selector, handler: Callback) plugin for easier event delegation
// handler is only called when $(event.target).is(delegate), in the scope of the jquery-object for event.target 

// provides triggerEvent(type: String, target: Element) to trigger delegated events
; (function ($) {
    $.each({
        focus: 'focusin',
        blur: 'focusout'
    }, function (original, fix) {
        $.event.special[fix] = {
            setup: function () {
                if ($.browser.msie) return false;
                this.addEventListener(original, $.event.special[fix].handler, true);
            },
            teardown: function () {
                if ($.browser.msie) return false;
                this.removeEventListener(original,
				$.event.special[fix].handler, true);
            },
            handler: function (e) {
                arguments[0] = $.event.fix(e);
                arguments[0].type = fix;
                return $.event.handle.apply(this, arguments);
            }
        };
    });
    $.extend($.fn, {
        mydelegate: function (type, delegate, handler) {
            return this.bind(type, function (event) {
                var target = $(event.target);
                if (target.is(delegate)) {
                    return handler.apply(target, arguments);
                }
            });
        },
        triggerEvent: function (type, target) {
            return this.triggerHandler(type, [$.event.fix({ type: type, target: target })]);
        }
    });
})(jQuery);


// 正则验证 zhanxp
jQuery.validator.addMethod("regular", function (value, element, param) {
	 
		var reg = new RegExp(param);
		return this.optional(element) || reg.test(value);		
	 
}, "不符合指定格式！");


 



// requiredif zhanxp
jQuery.validator.addMethod("requiredif", function (value, element, param) {

    var target = $("*.[name=" + param[0] + "]");
    if ($("input:[name=" + param[0] + "]").size() > 1) {
        target = $("input:checked:[name=" + param[0] + "]");
    }

    $(target).unbind(".validate-requiredif").bind("blur.validate-requiredif", function () {
        $(element).valid();
    });

    if ($(target).val() != param[1])
        return true;


    switch (element.nodeName.toLowerCase()) {
        case 'select':
            // could be an array for select-multiple or a string, both are fine this way
            var val = $(element).val();
            return val && val.length > 0;
        case 'input':
            if (this.checkable(element))
                return this.getLength(value, element) > 0;
        default:
            return $.trim(value).length > 0;
    }
}, "必须填写该项！");



// breakif zhanxp
jQuery.validator.addMethod("breakif", function (value, element, param) {
    var target = $("*.[name=" + param[0] + "]");
    if ($("input:[name=" + param[0] + "]").size() > 1) {
        target = $("input:checked:[name=" + param[0] + "]");
    }
    $(target).unbind(".validate-breakif").bind("blur.validate-breakif", function () {
        $(element).valid();
    });

    if ($(target).val() == param[1])
        return "break-validate";
    return true;
}, "");


// requiredifnot zhanxp
jQuery.validator.addMethod("requiredifnot", function (value, element, param) {

    var target = $("*.[name=" + param[0] + "]");
    if ($("input:[name=" + param[0] + "]").size() > 1) {
        target = $("input:checked:[name=" + param[0] + "]");
    }

    $(target).unbind(".validate-requiredifnot").bind("blur.validate-requiredifnot", function () {
        $(element).valid();
    });

    if ($(target).val() == param[1])
        return true;

    switch (element.nodeName.toLowerCase()) {
        case 'select':
            // could be an array for select-multiple or a string, both are fine this way
            var val = $(element).val();
            return val && val.length > 0;
        case 'input':
            if (this.checkable(element))
                return this.getLength(value, element) > 0;
        default:
            return $.trim(value).length > 0;
    }
}, "必须填写该项！");



// breakifnot zhanxp
jQuery.validator.addMethod("breakifnot", function (value, element, param) {

    var target = $("*.[name=" + param[0] + "]");
    if ($("input:[name=" + param[0] + "]").size() > 1) {
        target = $("input:checked:[name=" + param[0] + "]");
    }

    $(target).unbind(".validate-requiredifnot").bind("blur.validate-breakifnot", function () {
        $(element).valid();
    });

    if ($(target).val() != param[1])
        return "break-validate";

    return true;
}, "");

 
// 正则验证 zhanxp
jQuery.validator.addMethod("notequalTo", function (value, element, param) {
    var target = $(param).unbind(".validate-notequalTo").bind("blur.validate-notequalTo", function () {
        $(element).valid();
    });
    return value != target.val();
}, "请输入不同的值！");

//birthday
jQuery.validator.addMethod("birthday", function (value, element, param) {
    var reg = new RegExp(/^(?:(?:1[6-9]|[2-9][0-9])[0-9]{2}([-])(?:(?:0?[1-9]|1[0-2])\1(?:0?[1-9]|1[0-9]|2[0-8])|(?:0?[13-9]|1[0-2])\1(?:29|30)|(?:0?[13578]|1[02])\1(?:31))|(?:(?:1[6-9]|[2-9][0-9])(?:0[48]|[2468][048]|[13579][26])|(?:16|[2468][048]|[3579][26])00)([-])0?2\2(?:29))$/);
    return this.optional(element) || reg.test(value);
}, "请输入正确的生日格式！");

//telDomain
jQuery.validator.addMethod("telDomain", function (value, element, param) {
	var regTail = /(.tel)$/;
    return this.optional(element) || !regTail.test(value);
}, "tel域名不能支持解析！");

// domain
jQuery.validator.addMethod("domain", function (value, element, param) {
    var reg = new RegExp(/^[a-zA-Z0-9\u4e00-\u9fa5][-a-zA-Z0-9\u4e00-\u9fa5]{0,62}(\.[a-zA-Z0-9\u4e00-\u9fa5][-a-zA-Z0-9\u4e00-\u9fa5]{0,62})+\.?$/);
    return this.optional(element) || reg.test(value);
}, "请输入正确的域名！");

//domain
jQuery.validator.addMethod("domainwww", function (value, element, param) {
	if($.trim(value).indexOf("www.")>-1){
		 value=value.split("www.")[1];
	}
    var reg = new RegExp(/^[a-zA-Z0-9\u4e00-\u9fa5][-a-zA-Z0-9\u4e00-\u9fa5]{0,62}(\.[a-zA-Z0-9\u4e00-\u9fa5][-a-zA-Z0-9\u4e00-\u9fa5]{0,62})+\.?$/);
    return this.optional(element) || reg.test(value);
}, "请输入正确的域名！");

// domainen
jQuery.validator.addMethod("domainen", function (value, element, param) {
    var reg = new RegExp(/^[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+\.?$/);
    return this.optional(element) || reg.test(value);
}, "请输入正确的英文域名！");

//domainen without ext
jQuery.validator.addMethod("domainEnWithoutExt", function (value, element, param) {
  var reg = /^[-a-zA-Z0-9]{1,63}$/;
  var regHead = /^[a-zA-Z0-9]/;
  var regTail = /[a-zA-Z0-9]$/;
  return this.optional(element) || (reg.test(value) && regHead.test(value) && regTail.test(value) && !(value.indexOf("xn--")==0));
}, "请输入正确的英文域名！");

//domaincn without ext
jQuery.validator.addMethod("domainCnWithoutExt", function (value, element, param) {
  var reg = new RegExp(/^[-a-zA-Z0-9\u4E00-\u9FA5]{1,}$/);
  var regCn = /[\u4E00-\u9FA5]/;
  var regHead = /^[a-zA-Z0-9\u4E00-\u9FA5]/;
  var regTail = /[a-zA-Z0-9\u4E00-\u9FA5]$/;
  return this.optional(element) || (reg.test(value) && regCn.test(value) && regHead.test(value) && regTail.test(value) 
		  && this.getBytesLen(value)<=63);
}, "请输入正确的中文域名！");
 
//domaincc without ext
jQuery.validator.addMethod("domaincc", function (value, element, param) {
  var reg= /^[0-9]{6,14}$/;
  return this.optional(element) || !reg.test(value);
}, "cc域名不允许注册6-14的纯数字！");

//domainname
jQuery.validator.addMethod("domainname", function (value, element, param) {
	  var reg= /^[0-9]+$/;
	  return this.optional(element) || !reg.test(value);
	}, ".name域名不能注册纯数字！");

//====20120306加入域名检测函数相关
jQuery.validator.addMethod("isDomain", function (value, element, param) {
	 var cnlist =',AC,AD,AE,AERO,AF,AG,AI,AL,AM,AN,AO,AQ,AR,ARPA,AS,ASIA,AT,AU,AW,AX,AZ';
	    cnlist += ',BA,BB,BD,BE,BF,BG,BH,BI,BIZ,BJ,BL,BM,BN,BO,BR,BS,BT,BV,BW,BY,BZ';
	    cnlist += ',CA,CAT,CC,CD,CF,CG,CH,CI,CK,CL,CM,CN,CO,COM,COOP,CR,CU,CV,CX,CY,CZ,DE,DJ,DK,DM,DO,DZ';
	    cnlist += ',EC,EDU,EE,EG,EH,ER,ES,ET,EU,FI,FJ,FK,FM,FO,FR,GA,GB,GD,GE,GF,GG,GH,GI,GL,GM,GN,GOV,GP,GQ,GR,GS,GT,GU,GW,GY';
	    cnlist += ',HK,HM,HN,HR,HT,HU,ID,IE,IL,IM,IN,INFO,INT,IO,IQ,IR,IS,IT,JE,JM,JO,JOBS,JP,KE,KG,KH,KI,KM,KN,KP,KR,KW,KY,KZ';
	    cnlist += ',LA,LB,LC,LI,LK,LR,LS,LT,LU,LV,LY,MA,MC,MD,ME,MF,MG,MH,MIL,MK,ML,MM,MN,MO,MOBI,MP,MQ,MR,MS,MT,MU,MUSEUM,MV,MW,MX,MY,MZ,NA,NAME,NC,NE,NET,NF,NG,NI,NL,NO,NP,NR,NU,NZ';
	    cnlist += ',OM,ORG,PA,PE,PF,PG,PH,PK,PL,PM,PN,PR,PRO,PS,PT,PW,PY,QA,RE,RO,RS,RU,RW,SA,SB,SC,SD,SE,SG,SH,SI,SJ,SK,SL,SM,SN,SO,SR,ST,SU,SV,SY,SZ';
	    cnlist += ',TC,TD,TEL,TF,TG,TH,TJ,TK,TL,TM,TN,TO,TP,TR,TRAVEL,TT,TV,TW,TZ,UA,UG,UK,UM,US,UY,UZ,VA,VC,VE,VG,VI,VN,VU,WF,WS,YE,YT,YU,ZA,ZM,ZW,中国,公司,网络,';
		var i=0;
		var j=0;
		var length=value.length; 
		if (value.charAt(0)=='.')
			return false;
		if ( value.charAt(length-1)=='.')
			return false;
		if (value.charAt(0)=='-')
			return false;
		if ( value.charAt(length-1)=='-')
			return false;
		while (i<length)
		{ 
			if (value.charAt(i)=='.')	j++;
			i++;
		}
		if (j==0)
			return false; 
		else
		{
			var domainObjArray=value.split(";"); 
			var reg = new RegExp(/^[0-9a-zA-Z-]{1,}$/);
			for (i=0;i< domainObjArray.length ;i++)
			{
				var domainElementsArray = domainObjArray[i].split(".");
				for(var j=0;j<domainElementsArray.length;j++){
					if (reg.test(domainElementsArray[j])==false )
						return false;					
					if(cnlist.indexOf(','+domainElementsArray[domainElementsArray.length-1].toUpperCase()+',') <=0)
						return false;
				}
			} 
		}

	     return true;
	
}, "网站域名输入有误,请检查！ ");

//====20120306加入域名检测函数相关//域名可以使中英文.
jQuery.validator.addMethod("isDomainEnglishChinese", function (value, element, param) {
	 var cnlist =',AC,AD,AE,AERO,AF,AG,AI,AL,AM,AN,AO,AQ,AR,ARPA,AS,ASIA,AT,AU,AW,AX,AZ';
	    cnlist += ',BA,BB,BD,BE,BF,BG,BH,BI,BIZ,BJ,BL,BM,BN,BO,BR,BS,BT,BV,BW,BY,BZ';
	    cnlist += ',CA,CAT,CC,CD,CF,CG,CH,CI,CK,CL,CM,CN,CO,COM,COOP,CR,CU,CV,CX,CY,CZ,DE,DJ,DK,DM,DO,DZ';
	    cnlist += ',EC,EDU,EE,EG,EH,ER,ES,ET,EU,FI,FJ,FK,FM,FO,FR,GA,GB,GD,GE,GF,GG,GH,GI,GL,GM,GN,GOV,GP,GQ,GR,GS,GT,GU,GW,GY';
	    cnlist += ',HK,HM,HN,HR,HT,HU,ID,IE,IL,IM,IN,INFO,INT,IO,IQ,IR,IS,IT,JE,JM,JO,JOBS,JP,KE,KG,KH,KI,KM,KN,KP,KR,KW,KY,KZ';
	    cnlist += ',LA,LB,LC,LI,LK,LR,LS,LT,LU,LV,LY,MA,MC,MD,ME,MF,MG,MH,MIL,MK,ML,MM,MN,MO,MOBI,MP,MQ,MR,MS,MT,MU,MUSEUM,MV,MW,MX,MY,MZ,NA,NAME,NC,NE,NET,NF,NG,NI,NL,NO,NP,NR,NU,NZ';
	    cnlist += ',OM,ORG,PA,PE,PF,PG,PH,PK,PL,PM,PN,PR,PRO,PS,PT,PW,PY,QA,RE,RO,RS,RU,RW,SA,SB,SC,SD,SE,SG,SH,SI,SJ,SK,SL,SM,SN,SO,SR,ST,SU,SV,SY,SZ';
	    cnlist += ',TC,TD,TEL,TF,TG,TH,TJ,TK,TL,TM,TN,TO,TP,TR,TRAVEL,TT,TV,TW,TZ,UA,UG,UK,UM,US,UY,UZ,VA,VC,VE,VG,VI,VN,VU,WF,WS,YE,YT,YU,ZA,ZM,ZW,中国,公司,网络,';
		var i=0;
		var j=0;
		var length=value.length; 
		if (value.charAt(0)=='.')
			return false;
		if ( value.charAt(length-1)=='.')
			return false;
		if (value.charAt(0)=='-')
			return false;
		if ( value.charAt(length-1)=='-')
			return false;
		while (i<length)
		{ 
			if (value.charAt(i)=='.')	j++;
			i++;
		}
		if (j==0)
			return false; 
		else
		{
			var domainObjArray=value.split(";"); 
			var reg = new RegExp(/^[\u4e00-\u9fa5-!a-zA-Z0-9]+$/);
			for (i=0;i< domainObjArray.length ;i++)
			{
				var domainElementsArray = domainObjArray[i].split(".");
				for(var j=0;j<domainElementsArray.length;j++){
					if (reg.test(domainElementsArray[j])==false )
						return false;					
					if(cnlist.indexOf(','+domainElementsArray[domainElementsArray.length-1].toUpperCase()+',') <=0)
						return false;
				}
			} 
		}

	     return true;
	
}, "网站域名输入有误,请检查！ ");

jQuery.validator.addMethod("isCommonDomain", function (value, element, param) {
	var cnlist =',AC,AD,AE,AERO,AF,AG,AI,AL,AM,AN,AO,AQ,AR,ARPA,AS,ASIA,AT,AU,AW,AX,AZ';
	cnlist += ',BA,BB,BD,BE,BF,BG,BH,BI,BIZ,BJ,BL,BM,BN,BO,BR,BS,BT,BV,BW,BY,BZ';
	cnlist += ',CA,CAT,CC,CD,CF,CG,CH,CI,CK,CL,CM,CN,CO,COM,COOP,CR,CU,CV,CX,CY,CZ,DE,DJ,DK,DM,DO,DZ';
	cnlist += ',EC,EDU,EE,EG,EH,ER,ES,ET,EU,FI,FJ,FK,FM,FO,FR,GA,GB,GD,GE,GF,GG,GH,GI,GL,GM,GN,GOV,GP,GQ,GR,GS,GT,GU,GW,GY';
	cnlist += ',HK,HM,HN,HR,HT,HU,ID,IE,IL,IM,IN,INFO,INT,IO,IQ,IR,IS,IT,JE,JM,JO,JOBS,JP,KE,KG,KH,KI,KM,KN,KP,KR,KW,KY,KZ';
	cnlist += ',LA,LB,LC,LI,LK,LR,LS,LT,LU,LV,LY,MA,MC,MD,ME,MF,MG,MH,MIL,MK,ML,MM,MN,MO,MOBI,MP,MQ,MR,MS,MT,MU,MUSEUM,MV,MW,MX,MY,MZ,NA,NAME,NC,NE,NET,NF,NG,NI,NL,NO,NP,NR,NU,NZ';
	cnlist += ',OM,ORG,PA,PE,PF,PG,PH,PK,PL,PM,PN,PR,PRO,PS,PT,PW,PY,QA,RE,RO,RS,RU,RW,SA,SB,SC,SD,SE,SG,SH,SI,SJ,SK,SL,SM,SN,SO,SR,ST,SU,SV,SY,SZ';
	cnlist += ',TC,TD,TEL,TF,TG,TH,TJ,TK,TL,TM,TN,TO,TP,TR,TRAVEL,TT,TV,TW,TZ,UA,UG,UK,UM,US,UY,UZ,VA,VC,VE,VG,VI,VN,VU,WF,WS,YE,YT,YU,ZA,ZM,ZW,中国,公司,网络,';
	var i=0;
	var j=0;
	//默认加入www和cn结尾的模板前缀和后缀，主要是为了验证通用域名中间部分的合法性
	value= "www."+$.trim(value)+".com";
	
	var length=value.length; 
	if (value.charAt(0)=='.')
		return false;
	if ( value.charAt(length-1)=='.')
		return false;
	if (value.charAt(0)=='-')
		return false;
	if ( value.charAt(length-1)=='-')
		return false;
	while (i<length)
	{ 
		if (value.charAt(i)=='.')	j++;
		i++;
	}
	if (j==0)
		return false; 
	else
	{
		var domainObjArray=value.split(";");   
		var reg = new RegExp(/^[\u4e00-\u9fa5-!a-zA-Z0-9]+$/);
		for (i=0;i< domainObjArray.length ;i++)
		{
			var domainElementsArray = domainObjArray[i].split(".");
			for(var j=0;j<domainElementsArray.length;j++){
				if (reg.test(domainElementsArray[j])==false )
					return false;					
				if(cnlist.indexOf(','+domainElementsArray[domainElementsArray.length-1].toUpperCase()+',') <=0)
					return false;
			}
		} 
	}
	
	return true;
	
}, "只允许输入中文字母数字!-号！ ");
//检测域名是否最多只输入三个域名；分隔并且不能重复
jQuery.validator.addMethod("domianWithInThree_unrepeat", function (value, element, param) {
	    var domainArray =  value.replace(/"；"/g, ';').split(";");
	    if (domainArray.length > 3) {
	        return false;
	    }
	    //代替旧版的same函数
	    var str = value.replace(/"；"/g, ';')
	    str = str.toUpperCase();
	    var arr = str.split(";"); 
	    for (var i = 0; i < arr.length; i++) {
	        for (var j = i + 1; j < arr.length; j++) {
	            if (arr[i] == (arr[j])) {
	                return false;
	            }
	        }
	    }
	    return true;
}, "最多只输入三个域名；分隔并且不能重复");
 
//====================20120306结束========================
//domaintop
jQuery.validator.addMethod("domaintop", function (value, element, param) {
    if (this.optional(element))
        return true;

    var exts = ".com.edu.gov.int.net.org.biz.info.pro.name.museum.coop.aero.idv.mobi.tel.asia.me.tv.公司.网络.中国.ac.ad.ae.af.ag.ah.ai.al";
    exts = exts + ".am.an.ao.aq.ar.as.at.au.aw.az.ba.bb.bd.be.bf.bg.bh.bi.bj.bm.bn.bo.br.bs.bt.bv.bw.by.bz.ca";
    exts = exts + ".cc.cd.cf.cg.ch.ci.ck.cl.cm.cn.co.cq.cr.cu.cv.cx.cy.cz.de.dj.dk.dm.do.dz.ec.ee.eg.eh.er.es";
    exts = exts + ".et.eu.fi.fj.fk.fm.fo.fr.ga.gd.ge.gf.gg.gh.gi.gl.gm.gn.gp.gq.gr.gs.gt.gu.gw.gx.gy.gz.ha.hb";
    exts = exts + ".he.hi.hk.hl.hm.hn.hr.ht.hu.id.ie.il.im.in.io.iq.ir.is.it.je.jl.jm.jo.jp.js.jx.ke.kg.kh.ki";
    exts = exts + ".km.kn.kp.kr.kw.ky.kz.la.lb.lc.li.lk.ln.lr.ls.lt.lu.lv.ly.ma.mc.md.mg.mh.mk.ml.mm.mn.mo.mp";
    exts = exts + ".mq.mr.ms.mt.mu.mv.mw.mx.my.mz.na.nc.ne.nf.ng.ni.nl.nm.no.np.nr.nu.nx.nz.om.pa.pe.pf.pg.ph";
    exts = exts + ".pk.pl.pm.pn.pr.ps.pt.pw.py.qa.qh.re.ro.ru.rw.sa.sb.sc.sd.se.sg.sh.si.sj.sk.sl.sm.sn.so.sr";
    exts = exts + ".st.sv.sx.sy.sz.tc.td.tf.tg.th.tj.tk.tl.tm.tn.to.tp.tr.tt.tv.tw.tz.ua.ug.uk.um.us.uy.uz.va";
    exts = exts + ".vc.ve.vg.vi.vn.vu.wf.ws.xj.xz.ye.yn.yt.yu.yr.za.zj.zm.zw";

    var valList = value.split(".");
    if (valList.length >= 4 || valList.length <= 1)
        return false;
    if (valList[0] == "mail")
        return false;
    if (valList[0].indexOf("xn--") == 0)
        return false;

    if (valList.length == 2) {
        //后缀为顶级域名或则国别域名
        if (exts.indexOf("." + valList[1]) == -1)
            return false;
    }
    if (valList.length == 3) {
        //二级域名
        if (exts.indexOf("." + valList[1]) == -1)
            return false;
        else {
            if (valList[1] == "" || valList[2] == "")
                return false;
            if (valList[1].length > 2) {
                if (valList[2].length > 2 || exts.indexOf("." + valList[2]) == -1)
                    return false;
            }
            if (",cc,tv,me,cn,".indexOf(valList[1]) > 0) //.cc .tv .me .hk .cn都是顶级域名 暂时后边不接任何其他根域名
                return false;
            if (exts.indexOf("." + valList[2]) == -1)
                return false;
        }
    }
    return true;

}, "请输入正确的顶级域名！");

//====================20120306结束========================
//domainTwo 二级域名以下（包含二级域名）
jQuery.validator.addMethod("domainTwo", function (value, element, param) {
  if (this.optional(element))
      return true;

  var exts = ".com.edu.gov.int.net.org.biz.info.pro.name.museum.coop.aero.idv.mobi.tel.asia.me.tv.公司.网络.中国.ac.ad.ae.af.ag.ah.ai.al";
  exts = exts + ".am.an.ao.aq.ar.as.at.au.aw.az.ba.bb.bd.be.bf.bg.bh.bi.bj.bm.bn.bo.br.bs.bt.bv.bw.by.bz.ca";
  exts = exts + ".cc.cd.cf.cg.ch.ci.ck.cl.cm.cn.co.cq.cr.cu.cv.cx.cy.cz.de.dj.dk.dm.do.dz.ec.ee.eg.eh.er.es";
  exts = exts + ".et.eu.fi.fj.fk.fm.fo.fr.ga.gd.ge.gf.gg.gh.gi.gl.gm.gn.gp.gq.gr.gs.gt.gu.gw.gx.gy.gz.ha.hb";
  exts = exts + ".he.hi.hk.hl.hm.hn.hr.ht.hu.id.ie.il.im.in.io.iq.ir.is.it.je.jl.jm.jo.jp.js.jx.ke.kg.kh.ki";
  exts = exts + ".km.kn.kp.kr.kw.ky.kz.la.lb.lc.li.lk.ln.lr.ls.lt.lu.lv.ly.ma.mc.md.mg.mh.mk.ml.mm.mn.mo.mp";
  exts = exts + ".mq.mr.ms.mt.mu.mv.mw.mx.my.mz.na.nc.ne.nf.ng.ni.nl.nm.no.np.nr.nu.nx.nz.om.pa.pe.pf.pg.ph";
  exts = exts + ".pk.pl.pm.pn.pr.ps.pt.pw.py.qa.qh.re.ro.ru.rw.sa.sb.sc.sd.se.sg.sh.si.sj.sk.sl.sm.sn.so.sr";
  exts = exts + ".st.sv.sx.sy.sz.tc.td.tf.tg.th.tj.tk.tl.tm.tn.to.tp.tr.tt.tv.tw.tz.ua.ug.uk.um.us.uy.uz.va";
  exts = exts + ".vc.ve.vg.vi.vn.vu.wf.ws.xj.xz.ye.yn.yt.yu.yr.za.zj.zm.zw";

  var valList = value.split(".");
  if (valList.length >= 5 || valList.length <= 1)
      return false;
  if (valList[0] == "mail")
      return false;
  if (valList[0].indexOf("xn--") == 0)
      return false;

  if (valList.length == 2) {
      //后缀为顶级域名或则国别域名
      if (exts.indexOf("." + valList[1]) == -1)
          return false;
  }
  if (valList.length == 3) {
      //二级域名或顶级
      if (exts.indexOf("." + valList[2]) == -1)
          return false;
  }
  if (valList.length == 4) {
      //二级域名
      if (exts.indexOf("." + valList[2]) == -1)
          return false;
      else {
          if (valList[2] == "" || valList[3] == "")
              return false;
          if (valList[2].length > 2) {
              if (valList[3].length > 2 || exts.indexOf("." + valList[3]) == -1)
                  return false;
          }
          if (",cc,tv,me,cn,".indexOf(valList[2]) > 0) //.cc .tv .me .hk .cn都是顶级域名 暂时后边不接任何其他根域名
              return false;
          if (exts.indexOf("." + valList[3]) == -1)
              return false;
      }
  }
  return true;

}, "请输入顶级域名或二级域名！");
// ip
jQuery.validator.addMethod("ip", function (value, element, param) {
    var reg = new RegExp(/((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]\d)|\d)(\.((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]\d)|\d)){3}/);
    return this.optional(element) || reg.test(value);
}, "请输入正确的IP地址！");

//非阿里云邮箱
jQuery.validator.addMethod("noAliyunEmail", function (value, element, param) {
	var arg = value.split("@");
    return this.optional(element) || arg[1]!='aliyun.com';
}, "请输入非阿里云邮箱！");


//endDate
jQuery.validator.addMethod("endDate", function (value, element, param) {
    var startDate = $("#" + param).val();
    return (startDate <= value);
}, "结束日期必须大于开始日期!");


// 身份证
jQuery.validator.addMethod("personalid", function (value, element, param) {
    var reg = new RegExp(/^(\d{6})(18|19|20)?(\d{2})([01]\d)([0123]\d)(\d{3})(\d|X|x)?$/);
    return this.optional(element) || (reg.test(value));
}, "请输入正确身份证号码！");

// 国家号码
jQuery.validator.addMethod("countryCode", function (value, element, param) {
    var str = "'244','93','355','213','376','1264','1268','54','374','247','61','43','994','1242','973','880','1246','375','32','501','229','1441','591','267','55','673','359','226','95','257','237','1','1345','236','235','56','86','57','242','682','506','53','357','420','45','253','1890','593','20','503','372','251','679','358','33','594','241','220','995','49','233','350','30','1809','1671','502','224','592','509','504','852','36','354','91','62','98','964','353','972','39','225','1876','81','962','855','327','254','82','965','331','856','371','961','266','231','218','423','370','352','853','261','265','60','960','223','356','1670','596','230','52','373','377','976','1664','212','258','264','674','977','599','31','64','505','227','234','850','47','968','92','507','675','595','51','63','48','689','351','1787','974','262','40','7','1758','1784','684','685','378','239','966','221','248','232','65','421','386','677','252','27','34','94','1758','1784','249','597','268','46','41','963','886','992','255','66','228','676','1809','216','90','993','256','380','971','44','598','233','58','84','967','381','263','243','260'";
    var reg = "'" + value + "'";
    return (str.search(reg) > -1);
}, "请输入86或者正确的国家区号！");


//通用网址通信信息限制
jQuery.validator.addMethod("tongyongMenu", function (value, element, param) {
	var cMenu=["广东","广州","深圳","珠海","汕头","韶关","河源","梅州","惠州","汕尾","东莞","中山","佛山","阳江","湛江","茂名","肇庆","清远","潮州","番禺","潮洲","花都","惠洲","大亚湾","连州","清新","潮安","普宁","揭东","顺德","澳门","香港"];
	for(var i=0;i<cMenu.length;i++){
		if(value.indexOf(cMenu[i]) > -1){
			return false; 
		}
	}
    return true;
}, "对不起，包含受限信息，请参见提示2");

//通用网址电话区号限制
jQuery.validator.addMethod("tongyongTelCode", function (value, element, param) {
	var telCode=["020","0660","0661","0662","0663", "0668","0750","0751", "0752","0753","0754","0755", "0756","0757","0758","0759","0760","0762","0763","0765","0766","0768","0769","853","00853", "852","00852"];
	for(var i=0;i<telCode.length;i++){
		if(value.indexOf(telCode[i]) > -1){
			return false; 
		}
	}
    return true;
}, "对不起，包含受限信息，请参见提示2");

//通用网址邮政编码限制
jQuery.validator.addMethod("tongyongPostCode", function (value, element, param) {
	var postCode=         
		["510000","511400","510800","510900","511300","516600","516400", "516700", "516500","515100","529500","529600","529500","529800", "515500","515500","515200","515400","515300","525000","525100","525200","525300","525400","529000","529200","529300","529400","529100","529700","512000","512100","512600","511100","512500","512300","512400","512700","512200","516000","526300", "516200","516100","511200","514000","514000","514100","514200","514300","514400","514500","514600","515000", "515800","515900","518000","518100","519000","519100","528000","528200","528500","528100","526000","526100","526200","526400","526500","526600","526300","524000","524300","524400","524500","524100","524200","528400","517000","517100","517200","517300","517400","511500","511600","513000","513200","513100", "513300","513400","528300","527300","527200","527100","527400","515600","515600","515700","511700","999077","999078"];
	for(var i=0;i<postCode.length;i++){
		if(value.indexOf(postCode[i]) > -1){
			return false; 
		}
	}
    return true;
}, "对不起，包含受限信息，请参见提示2");


//弱密码校验--单引号空格等特别字符判断
jQuery.validator.addMethod("password_especially_character", function (value, element) {
	var reg = new RegExp(/[\s\"\”\“\‘\’\']/);
	var flag = reg.test(value);
	if(flag){
		return false;
	}else{
		return true;
	}
}, "密码不能包含非法字符");

//弱密码校验--单一字符组成的字符串判断,如：aaaaaaaa
jQuery.validator.addMethod("password_same_character", function (value, element) {
	var reg = new RegExp(/^(.)\1*$/);
	return !reg.test(value);
}, "密码不能设置为同一字符");

//弱密码校验--单一种类字符判断
jQuery.validator.addMethod("password_single_character", function (value, element) {
	var number_modes = 0;
	var english_modes = 0;
	var punctuation_modes = 0;
	for (i=0;i<value.length;i++){  
		//密码模式  
		modes = value.charCodeAt(i);
		if (modes>=48 && modes <=57) //数字  
			number_modes = 1;  
		else if (modes>=65 && modes <=90) //大写  
			english_modes =1;
		else if (modes>=97 && modes <=122) //小写  
			english_modes =1;  
		else  
			punctuation_modes =1; 
	}  
    if((number_modes+english_modes+punctuation_modes)>1){
    	return true;
    }else{
    	return false;
    }
}, "密码不能设置为纯数字、字母或符号");

//shj
jQuery.validator.addMethod("isEmptyNotTrim", function (value, element, param) {

    var target = $("*.[name=" + param[0] + "]");
    if ($("input:[name=" + param[0] + "]").size() > 1) {
        target = $("input:checked:[name=" + param[0] + "]");
    }

    $(target).unbind(".validate-requiredif").bind("blur.validate-requiredif", function () {
        $(element).valid();
    });

    if ($(target).val() != param[1])
        return true;


    switch (element.nodeName.toLowerCase()) {
        case 'select':
            // could be an array for select-multiple or a string, both are fine this way
            var val = $(element).val();
            return val && val.length > 0;
        case 'input':
            if (this.checkable(element))
                return this.getLength(value, element) > 0;
        default:
            return value.length > 0;
    }
}, "必须填写该项！");

