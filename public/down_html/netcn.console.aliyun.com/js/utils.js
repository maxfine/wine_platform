/**
 * 时间对象的格式化;
 */
Date.prototype.format = function(format) {
	/*
	 * eg:format="yyyy-MM-dd hh:mm:ss";
	 */
	var o = {
		"M+" : this.getMonth() + 1, // month
		"d+" : this.getDate(), // day
		"h+" : this.getHours(), // hour
		"m+" : this.getMinutes(), // minute
		"s+" : this.getSeconds(), // second
		"q+" : Math.floor((this.getMonth() + 3) / 3), // quarter
		"S" : this.getMilliseconds()
	// millisecond
	};

	if (/(y+)/.test(format)) {
		format = format.replace(RegExp.$1, (this.getFullYear() + "")
				.substr(4 - RegExp.$1.length));
	}

	for ( var k in o) {
		if (new RegExp("(" + k + ")").test(format)) {
			format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k]
					: ("00" + o[k]).substr(("" + o[k]).length));
		}
	}
	return format;
};

var urlUtils = {
	getParameterByName : function(name) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regexS = "[\\?&]" + name + "=([^&#]*)";
		var regex = new RegExp(regexS);
		var results = regex.exec(window.location.href);
		if (results == null)
			return "";
		else
			return decodeURIComponent(results[1].replace(/\+/g, " "));
	}
};

var formatCurrencyUtils = function(num) {
	var settings = {
		name : "formatCurrency",
		colorize : false,
		region : '',
		global : true,
		roundToDecimalPlace : 2,
		eventOnDecimalsEntered : false,
		symbol : '',
		positiveFormat : '%s%n',
		negativeFormat : '%s-%n',
		decimalSymbol : '.',
		digitGroupSymbol : ',',
		groupDigits : true
	// regex : new RegExp("[^\\d" + settings.decimalSymbol + "-]", "g")
	};

	// evalutate number input
	var numParts = String(num).split('.');
	
	var hasDecimals = (numParts.length > 1);
	var decimals = (hasDecimals ? numParts[1].toString() : '0');
	var originalDecimals = decimals;

	// format number
	num = Math.abs(numParts[0]);
	num = isNaN(num) ? 0 : num;
	
	var isPositive = (num == Math.abs(num));
	if (settings.roundToDecimalPlace >= 0) {
		decimals = parseFloat('1.' + decimals); // prepend "0."; (IE does NOT
												// round 0.50.toFixed(0) up, but
												// (1+0.50).toFixed(0)-1
		decimals = decimals.toFixed(settings.roundToDecimalPlace); // round
		if (decimals.substring(0, 1) == '2') {
			num = Number(num) + 1;
		}
		decimals = decimals.substring(2); // remove "0."
	}
	num = String(num);

	if (settings.groupDigits) {
		for ( var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++) {
			num = num.substring(0, num.length - (4 * i + 3))
					+ settings.digitGroupSymbol
					+ num.substring(num.length - (4 * i + 3));
		}
	}

	if ((hasDecimals && settings.roundToDecimalPlace == -1)
			|| settings.roundToDecimalPlace > 0) {
		num += settings.decimalSymbol + decimals;
	}

	// format symbol/negative
	var format = isPositive ? settings.positiveFormat : settings.negativeFormat;
	var money = format.replace(/%s/g, settings.symbol);
	return money.replace(/%n/g, num);

};

var saleContentUtils = {
		getContent: function(relatedName, userInput){
			var result="";
			
			if(relatedName != null && relatedName != "")
				return relatedName;
			
			if(userInput != undefined && userInput != null && userInput != "") {
				var jsonUserInput = $.evalJSON(userInput);
				if(jsonUserInput.c_productName != undefined)
					result = jsonUserInput.c_productName;
				
				if(jsonUserInput.c_productDesc != undefined)
					result = jsonUserInput.c_productDesc;
			}
			
			return result;
		}
};

var domainFunctionRedirectUtils = {
		
		domainFunctionRedirect : function(fucnType, params) {
			var me = domainFunctionRedirectUtils;
			
			if(fucnType == "printCertificate") { //证书打印
				me.printCertificate(params);
			} else if(fucnType == "regInfoProtection") { //注册信息保护
				me.regInfoProtection(params);
			} else if(fucnType == "chargeSaftyLock") { //域名信息安全锁(管理)
				me.chargeSaftyLock(params);
			} else if(fucnType == "askTransferPassword") { //索取域名转移密码				
				me.askTransferPassword(params);
			} else if(fucnType == "changeDNS") { //修改DNS			
				me.changeDNS(params);
			} else if(fucnType == "checkDomainHealthy") { //域名体检			
				me.checkDomainHealthy(params);
			} else if(fucnType == "domainParse") { //域名解析			
				me.domainParse(params);
			} else if(fucnType == "changeRegContractInfo") { //修改注册联系人信息	
				me.changeRegContractInfo(params);
			} else if(fucnType == "changeAdminContractInfo") { //修改管理联系人信息	
				me.changeAdminContractInfo(params);
			} else if(fucnType == "changeBillContractInfo") { //修改付款联系人信息	
				me.changeBillContractInfo(params);
			} else if(fucnType == "changeTechContractInfo") { //修改技术联系人信息	
				me.changeTechContractInfo(params);
			} else if(fucnType == "pauseSaftyLock") { //暂停域名锁	
				me.pauseSaftyLock(params);
			}
		},
		
		printCertificate : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		regInfoProtection : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		chargeSaftyLock : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		askTransferPassword : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		changeDNS : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		checkDomainHealthy : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		domainParse : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		changeRegContractInfo : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		changeAdminContractInfo : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		changeBillContractInfo : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		changeTechContractInfo : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		},
		
		pauseSaftyLock : function(params) {
			alert("请确认URL以及参数类型，然后修改utils.js中的跳转方法进行跳转");
			return false;
		}
};

String.prototype.escapeHTML = function () {
	return this.replace(/&/g, '&amp;').replace(/>/g, '&gt;').replace(/</g, '&lt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
};