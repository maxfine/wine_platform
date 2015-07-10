define(function(require, exports, module){
	//window.$ = require('jquery');
	//登录加载socket.io库
	//if(OP_CONFIG.userInfo){
	//	require.async('socket.io');
	//	require('chat');
	//	$.chat.init();
	//}
	var store=require('store');
	//计算字符串长度
	String.prototype.strLen = function() {
	    var len = 0;
	    for (var i = 0; i < this.length; i++) {
	        if (this.charCodeAt(i) > 255 || this.charCodeAt(i) < 0) len += 2; else len ++;
	    }
	    return len;
	}


	//将字符串拆成字符，并存到数组中
	String.prototype.strToChars = function(){
	    var chars = new Array();
	    for (var i = 0; i < this.length; i++){
	        chars[i] = [this.substr(i, 1), this.isCHS(i)];
	    }
	    String.prototype.charsArray = chars;
	    return chars;
	}

	//判断某个字符是否是汉字
	String.prototype.isCHS = function(i){
	    if (this.charCodeAt(i) > 255 || this.charCodeAt(i) < 0)
	        return true;
	    else
	        return false;
	}

	//截取字符串（从start字节到end字节）
	String.prototype.subCHString = function(start, end){
	    var len = 0;
	    var str = "";
	    this.strToChars();
	    for (var i = 0; i < this.length; i++) {
	        if(this.charsArray[i][1])
	            len += 2;
	        else
	            len++;
	        if (end < len)
	            return str;
	        else if (start < len)
	            str += this.charsArray[i][0];
	    }
	    return str;
	}

	//截取字符串（从start字节截取length个字节）

	String.prototype.subCHStr = function(start, length){
	    return this.subCHString(start, start + length);
	}
	//load socket
	require.async('chat', function(){
        $.chat.init();
    });
	//非学习页加载头部和回到顶部脚本
	function popLoginSns(){
		require.async('../../logic/login/login-regist', function(login){
			login.init();
		});
	}

	(OP_CONFIG.page=='code') && $('#J_GotoTop').hide()


	function backTop(){
		h = $(window).height();
		t = $(document).scrollTop();
		if(t >=768){
			$('#backTop').show();
		}else{
			$('#backTop').hide();
		}
	}
	//顶部用户导航
	/*		if($('#nav_list').is(":visible")){
			$(this).removeClass("hover")
			$('#nav_list').hide();
		}else{
			$(this).addClass("hover")
			$('#nav_list').show();
		}

		return false;*/
	$('[action-type="my_menu"],#nav_list').on('mouseenter',function(){
		$('[action-type="my_menu"]').addClass("hover")
		$('#nav_list').show()
	})
    $('[action-type="my_menu"],#nav_list').on('mouseleave',function(){
		$('[action-type="my_menu"]').removeClass("hover")
	$('#nav_list').hide()
	});
	$('#set_btn').click(function() { location.href='/space/course' });

	$('#js-signin-btn').on('click',function(e){
		e.preventDefault();
		require.async('../../logic/login/login-regist', function(login){
			login.init();
		});
	});
	$('#js-signup-btn').on('click',function(e){
		e.preventDefault();
		require.async('../../logic/login/login-regist', function(login){
			login.signup();
		});
	});

	//回到顶部
	$(document).ready(function(e) {
		backTop();
		$('#backTop').click(function(){
			$("html,body").animate({scrollTop:0},200);
		})

	});

	//点击课程链接 清空原来存储选项
	$("#nav-item a:eq(0)").click(function(event) {
		//store.clear();
		store.remove('lange_id');
		store.remove('pos_id');
		store.remove('tab_id');
		store.remove('is_easy');
		store.remove('sort');
	});

	$(window).scroll(function(e){
		backTop();
	});



	// $(".wenda-head,.wenda-nickname").on({
	// 	mousemove:function(){


	// 		var _t=$(this).offset().top
	// 		var _l=$(this).offset().left
	// 		var _w=$(this).innerWidth()
	// 		var _h=$(this).innerHeight()

	// 		var usercard='<div class="layer-usercard" style="left:'+(_l+_w/2-74)+'px;top:'+(_t+_h+11)+'px">\
	// 			  <div class="arrow"></div>\
	// 			  <div class="layer-usercard-header">\
	// 					<dt>丢三但不落四</dt>\
	// 					<dd class="avatar">\
	// 			            <img width="60" height="60" src="http://img.mukewang.com/user/53d9d0930001f7c305900311-60-60.jpg">\
	// 			        </dd>\
	// 			        <dd>慕课网产品经理</dd>\
	// 			        <dd>我的心容易急躁，容易发火容易发火，容易...</dd>\
	// 			  </div>\
	// 			  <div class="layer-usercard-info">\
	// 			  		<ul>\
	// 			  			<li><span>MP</span> 18,769</li>\
	// 			  			<li class="noborder"><span>徽章</span> 2,450</li>\
	// 			  			<li class="layer-usercard-medal">\
	// 			  			<a href="" title="勋章"><img width=32 height=32 src="http://img.t.sinajs.cn/t4/style/images/medal/299_s.gif"></a>\
	// 			  			<a href="" title="勋章"><img width=32 height=32 src="http://img.t.sinajs.cn/t4/style/images/medal/363_s.gif"></a>\
	// 			  			<a href="" title="勋章"><img width=32 height=32 src="http://img.t.sinajs.cn/t4/style/images/medal/299_s.gif"></a>\
	// 			  			</li>\
	// 			  		</ul>\
	// 			  </div>\
	// 			</div>'
	// 		clearTimeout(window.cardTimer)
	// 		window.cardTimer=setTimeout(function(){
	// 			$(".layer-usercard").remove()
	// 			$(document.body).append(usercard);

	// 		},1000)
	// 	},
	// 	mouseout:function(){
	// 		clearTimeout(window.cardTimer)
	// 		$(".layer-usercard").remove()
	// 	}
	// })

	!function(){
		var cookie,
			ua,
			match;
		ua=window.navigator.userAgent;
		match=/;\s*MSIE (\d+).*?;/.exec(ua);
		if(match&&+match[1]<9){
			cookie=document.cookie.match(/(?:^|;)\s*ic=(\d)/);
			if(cookie&&cookie[1]){
				return ;
			}
			$("body").prepend([
				"<div id='js-compatible' class='compatible-contianer'>",
					"<p class='cpt-ct'><i></i>您的浏览器版本过低。为保证最佳学习体验，<a href='/static/html/browser.html'>请点此更新高版本浏览器</a></p>",
					"<div class='cpt-handle'><a href='javascript:;' class='cpt-agin'>以后再说</a><a href='javascript:;' class='cpt-close'><i></i></a>",
				"</div>"
			].join(""));
			$("#js-compatible .cpt-agin").click(function(){
				var d=new Date();
				d.setTime(d.getTime()+30*24*3600*1000);
				//d.setTime(d.getTime()+60*1000);
				document.cookie="ic=1; expires="+d.toGMTString()+"; path=/";
				$("#js-compatible").remove();
			});
			$("#js-compatible .cpt-close").click(function(){
				$("#js-compatible").remove();
			});
		}
	}();


	//---全局搜索----------------------------
	var timer=null;
	var currIndex=-1;


	var searchFun=function(obj){
	    var $this=obj;
		(timer) && clearTimeout( timer );
		timer=setTimeout(function(){
			if($.trim($this.val())){
				$.ajax({
					type: "POST",
					url: "/index/ajaxgetsearch",
					dataType:"json",
					data: {
						search_title:$.trim($this.val())
					},
					success: function(res){

						currIndex=-1;
						var courselist=res.data.courseList
						var bbslist=res.data.bbsList
						if(courselist.length !=0||bbslist.length !=0) {
							var str="<dt>搜索 <span>"+$("<div/>").text($this.val()).html()+"</span> 相关课程和问答</dt>";
							if(courselist.length !=0){
								for(var i=0;i<courselist.length;i++){
	                                var course = courselist[i];
									var name = course.name;
	                                var id = course.cid;
									var subname = name.strLen()>40?name.subCHStr(0,38)+"..":name;
									str+='<dd title="'+name+'"><a class="course" target="_blank" href="/view/'+id+'"><span>'+subname+'</span></a></dd>';
								}
							}
							if(bbslist.length !=0){
								for(var i=0;i<bbslist.length;i++){
	                                var course = bbslist[i];
									var name = course.title||course.description;
									name=$("<div/>").text(name).html()
	                                var id = course.id;
									var subname = name.strLen()>40?name.subCHStr(0,38)+"..":name;
									var linkurl="/wenda/detail/"
									if(course.type_id==2){
										linkurl="/qadetail/"
										id=course.old_ques_id
									}
									str+='<dd title="'+name+'"><a class="wenda" target="_blank" href="'+linkurl+id+'"><span>'+subname+'</span></a></dd>';
								}
							}
							$(".search-area-result").html(str).css("z-index",99999).show();
							$this.attr("data-old",$this.val());
						}else{
							$(".search-area-result").hide().html("");
						}
					}
				});
			}else{
				$(".search-area-result").hide().html("");
			}
	   },400)
	}

	var searchListen=function(){
		var objs=$(".search-area-result dd").removeClass('curr')
		var keyword=""

		if(currIndex>-1){
			keyword=$(objs.get(currIndex)).addClass('curr').attr("title")
		}else{
			keyword=$(".js-input-keyword").attr("data-old")
		}
		//$(".js-keyword").val(keyword);
	}

	var bindEvent=function(){
		$(".js-input-keyword").on(
			{'keydown': function (event) {
				(timer) && clearTimeout( timer );
	            switch (event.keyCode) {
	                case 13://回车
                        if(currIndex > -1){
                            $(".search-area-result dd").eq(currIndex).find("a")[0].click();
                            return false;
                        }
						var keyword =$.trim($(this).val());
						if(!keyword) return false;
						$(".search-area-result").hide().html("");
						currIndex=-1;
						//$('[name="search-form"]').submit();
						//this.form.submit();
	                	//return false;
	                break;
	                case 38:
	                	currIndex=currIndex>-1?currIndex-1:$(".search-area-result dd").length-1
	                	searchListen()
	                break;
	                case 40:
	                	currIndex=currIndex<$(".search-area-result dd").length-1?currIndex+1:-1
	                	searchListen()
	                break;
	                default:
	                	searchFun($(this));
	            }
        	},
        	'focus':function(){
        		$(".search-area").addClass('focus');
				if($.trim($(this).val())) {
					searchFun($(this));
				}

        	},
        	'blur':function(){
        		if(!$.trim($(this).val())) {
					$(".search-area").removeClass('focus');
        		}
        		setTimeout(function(){
        			$(".search-area-result").hide().html("");
        		},200)

        	}
    	});

		$(".js-btn-search").on("click",function(){
			var keyword =$.trim($(".js-input-keyword").val());
			if(!keyword) return false;
			$(".search-area-result").hide().html("");
			currIndex=-1;
			$(this).parent("form").submit();
			//$(this).attr({"href":"/index/search?words="+encodeURIComponent(keyword),"target":"_blank"});
		})


        $(".search-area-result").on({
        	'mouseover':function(event) {
        		$(this).addClass('curr').siblings().removeClass('curr')
        		currIndex=$(this).index()
        	},
        	'mouseout':function(event) {
        		$(this).removeClass('curr');
                currIndex = -1;
        	}
        },'dd')
	}

	bindEvent();
	//判断是否有ast参数，提交统计
	!function() {
		var search = window.location.search,
			ref = document.referrer;
		search = /ast=([^&]+)/.exec(search);
		if (ref && ~ref.indexOf('/course/discovery') && search && search[1]) {//从discovery页来 ，避免民刷新当前页统计
			$.get('/index/adclick', {ast: search[1], r: (new Date).getTime()});
		}
		$(document).on('click', '[data-ast]', function(){
			$.get('/index/adclick', {ast: $(this).attr('data-ast'), r: (new Date).getTime()});
		});
	}();

});
