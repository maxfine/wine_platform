define(function(require, exports, module){
	require('common');
	require('/static/lib/layer/1.6.0/layer.min.js');
	require('/static/lib/layer/1.6.0/skin/layer.css');
	require('../../../lib/jquery/plugin/jquery.scrollbar');
	require('../../../css/jquery.scrollbar.css');
	require('/static/component/base/placeholder/placeholder.js');
	require('jwplayer');
	require('/static/page/course/common/autocomplete.js');
	var store = require("store");

	if(!OP_CONFIG.userInfo){//判断当前用户是否登
		$(document).on("shown",function(e){
    		var $target;
    		if(($target=$(e.target)).hasClass("rl-modal")){
    			$target.find("[data-dismiss]").remove();//.end().find("a:contains('忘记密码')").remove();
    			$(".modal-backdrop").off("click");
    		}
    	});

		if(typeof thePlayer=="object") thePlayer.play(false);
	    require.async('login_sns', function(login){
	        login.init();
	    });
    }

	$('.detaillist').perfectScrollbar({
		wheelSpeed: 20,
		wheelPropagation: false
	});

	var chapterlist={
		show:function(){
			var $title=$('.chaptername'),
				$list=$("#sectionlist");
		  	$title.css({'background':'#262f33','z-index':1001,'color':'#fff'});
		  	//$('.chaptername').find('span').removeClass('borderstyle');
		  	if( $list.hasClass('hide') ) {
		      	$list.removeClass('hide');
		      	//判断当前正在学习的元素距离父容器的高度，如果超过则scrollTop到一定的位置
		      	var listHeight = $("#sectionlist b").parent('a').position().top;
				if(listHeight >= 450){
					$('.detaillist').scrollTop(listHeight);
					$('.detaillist').perfectScrollbar('update');//同步滚动条插件的scrollTop值
				}
			 	//$('#video_mark').css('height',$height);
		      	$('#video_mark').fadeIn();
				if(typeof thePlayer!="undefined"){
		     		if(thePlayer.getState() == 'PLAYING'){
			   	 		thePlayer.pause();
		      		}
				}
	    	}
		},
		hide:function(){
			$('#sectionlist').addClass('hide');
			$('#video_mark').fadeOut();
			$('.chaptername').css({'background':'','z-index':'','color':''});
			if(typeof thePlayer != 'undefined'&&thePlayer.getState()=="PAUSED"){
				thePlayer.play();
			}
		}
	}
	$('.chaptername').on('click',function(e){
		e.preventDefault();
	  	$("#sectionlist").is(":visible")? chapterlist.hide() : chapterlist.show();
	});
	$('#video_mark').click(function(){
		chapterlist.hide();
	});

	//ListData

	var GetListData={
		pl:require("/static/page/course/common/ajax-pl-list.js")({
			container:$('#plLoadListData'),
			params:{
				mid:pageInfo.mid
			}
		}),
		mate:require("/static/page/course/common/ajax-otherscode-list.js")({
			container:$('#mateLoadListData'),
			params:{
				mid:pageInfo.mid
			}
		}),
		qa:require("/static/page/course/common/ajax-discuss-list.js")({
			container:$('#qaLoadListData'),
			params:{
				mid:pageInfo.mid
			}
		}),
		note:require("/static/page/course/common/ajax-note-list.js")({
			container:$('#noteLoadListData'),
			params:{
				mid:pageInfo.mid
			},
			def:{ //template compalie pre define
				"media_id":pageInfo.mid,
				mediaType:'video' //required in diffrent page; 'video','code','ceping'
			}
		}),
		wiki:require("/static/page/course/common/ajax-wiki-list.js")({
			container:$('#wikiLoadListData'),
			params:{
				mid:pageInfo.mid
			}
		})
	};
	var initFun = {
		qa:function(){
			UE.getEditor("discuss-editor",{initialFrameHeight:80,autoFloatEnabled:false,autoClearinitialContent:true,initialStyle:'p{line-height:1.5em;font-size:13px;color:#444}'});
		}
	};
	exports.tabList=GetListData;

	var postData=window.postData={
		mid:pageInfo.mid,
		picture_url:'',
		picture_time:0
	}
	//tab切换
	var tabs = $('.course-menu a');
	tabs.one("click",function(e){
		//data loader
		var $this = $(this),id;
	 	//(typeof shot !='undefined')&&shot.reset()
		id = $(this).attr('id');
		id = id.substring(0,id.length-4);//sub the 'Menu' 4 char;
		initFun[id] && initFun[id]();
		GetListData[id] && GetListData[id].load();
    }).on("click",function(e){

    	var $this=$(this),
    		id;
    	e.preventDefault();
    	//(typeof shot !='undefined')&&shot.reset();
    	if($this.attr('id')=='wikiMenu'&&OP_CONFIG.userInfo.usertype>1) {//toggle create wiki button
		 	$('#js-create-wiki').show()
		}
		else{
			$('#js-create-wiki').hide()
	 	}
	 	if($this.hasClass("active")) return ;

	 	$this.parent().siblings().find(".active").removeClass("active");
	 	$this.addClass("active");
	 	id=$this.attr("id");
	 	id=id.substring(0,id.length-4);//sub the 'Menu' 4 char;
	 	$("#"+id+"-content").siblings(".list-tab-con").hide().end().show();
	 	store.set('ctb',$this.parent().index());
    });

    var tabIndex = 0;
    if(tabs.length > parseInt(store.get('ctb'))){
    	tabIndex = parseInt(store.get('ctb'));
    }
    tabs.eq(tabIndex).trigger("click");


	//placeholder rewrite
	if(!("placeholder" in document.createElement("input"))){
		$(".js-placeholder").each(function() {
			var $this = $(this);
			$this.val($this.attr('placeholder'));
		});
		$(document).on("focus",".js-placeholder",function(){
			var $this=$(this);
			if($this.val()==$this.attr("placeholder")){
				$this.val("").removeClass("placeholder");
			}
		})
		.on("blur",".js-placeholder",function(){
			var $this=$(this);
			if(!$this.val().length&&$this.attr("placeholder")){
				$this.addClass("placeholder").val($this.attr("placeholder"));
			}
		});
	}


	//发讨论

	function Store(name){
		this.name=name;
		this.data=null;
	}
	Store.prototype={
		reset:function(){
			this.data=null;
		},
		set:function(key,data){
			if(data===undefined){
				this.data=key;
			}
			else{
				this.data=this.data||{};
				this.data[key]=data;
			}
		},
		prev:function(data){
			$.extend(data,this.data);
		},
		extendMethod:function(name,fun){
			if(!this.name||typeof this[name]!="function") return ;
			this["_"+name]=this[name];
			this[name]=function(){
				this["_"+name].call(this);
				fun.call(this);
			}
		},
		success:$.noop
	}

	var remote={
		qa:new Store("qa"),
		note:new Store("note")
	}
	exports.remote=remote;

	//评论框
	$('#js-pl-input-fake').on({
		focusin: function() {
			$(this).addClass('ipt-fake-focus')
		},
		focusout: function() {
			$(this).removeClass('ipt-fake-focus');
		},
		keyup: function() {
			var len = $.trim($('#js-pl-textarea').val()).length;
			if( len > 300 ){
				$(this).addClass("ipt-fake-error").find('#js-pl-limit').addClass('limit-overflow');
			}
			else{
				$(this).removeClass("ipt-fake-error").find("#js-pl-limit").removeClass('limit-overflow')
			}
			$('#js-pl-limit').text(len);
		}
	})
	//发布评论
    function commentSubmit(checked){
        var $this = $('#js-pl-submit'),
            val;
        if( $this.hasClass("submit-loading") ) return ;
        val=$.trim( $('#js-pl-textarea').val() );
        if(val.length < 5 || val == $("#js-pl-textarea").attr('placeholder')){
            layer.msg('输入不能小于5个字符', 2, -1);
            return ;
        }
        if(val.length > 300){
            layer.msg('输入不能超过300个字', 2, -1);
            return;
        }
        $this.addClass("submit-loading").val("发布中...");
        var obj = {
            content:val,
            mid:pageInfo.mid
        };
        if(checked){obj.checked = 1}
        $.ajax({
            url: "/course/docomment",
            type: "post",
            dataType: "json",
            data: obj,
            success: function(data){
                if(data.result == -103008){
                    var $maybe = $("#maybe-wenda");
                    $maybe.show().addClass("show");
                    $("#qaMenu").click();
                    $("#plMenu").click();
                }else if(data.result == 0){
                    layer.msg('发布成功!', 2, -1);
                    $("#js-pl-textarea").val('').blur();
                    $('#js-pl-limit').text(0);
                    GetListData.pl.load();
                }
                else{
                    layer.msg(data.msg, 2, -1);
                }

            },
            complete: function(){
                $this.removeClass("submit-loading").val("发表评论");
            }
        })
    }
	$('#js-pl-submit').click(function(){
		commentSubmit(false);
	});
    //引导问答弹出框中得点击事件
    $("#wenda-ok").on("click", function(){
        var content = $.trim( $('#js-pl-textarea').val() );
        $('#js-pl-textarea').val("");
        $("#qaMenu").click();
        $("#maybe-wenda").removeClass("show").hide();
        UE.getEditor("discuss-editor").setContent(content);
        $("#js-qa-title").focus();
    });
    $("#wenda-no").on("click", function(){
        commentSubmit(true);
        $("#maybe-wenda").removeClass("show").slideUp("fast");
    });
   	$('#js-discuss-submit').on('click',function(){
	   	var $v,
	   		c,
	   		content,
	   		txt,
	   		txtLength,
	   		data={},
	   		title,
	   		$this=$(this);

		if($this.hasClass("submit-loading")) return;
		title = $.trim($('#js-qa-title').val());
		if(title.length < 5 || title === $('#js-qa-title').attr('placeholder')) {
			layer.msg('问答标题不能少于5个字', 2, -1);
		  	return;
		}
		else if(title.length > 255) {
			layer.msg('问答标题不能大于255个字', 2, -1);
		  	return;
		}

		content=UE.getEditor("discuss-editor").getContent();
		content=$.trim(content);
		txt=$.trim(UE.getEditor("discuss-editor").getContentTxt());
		txtLength=txt.length;
	  	if(txtLength==0||txt=="请输入讨论内容..."){
		  	layer.msg('请输入讨论内容', 2, -1);
		  	return;
		}
	  	if(txtLength < 5){
		   	layer.msg('输入不能小于5个字符', 2, -1);
			return;
		}
	  	if(content.length >20000){
	   		layer.msg('输入不能超过20000个字', 2, -1);
	   		return;
	  	}
	  	if(($v=$("#js-discuss-btm .verify-code")).length){
	  		c=$v.find("input").val();
	  		if(c.length==0){
	  			layer.msg("请输入验证码",2,-1);
	  			return ;
	  		}
	  		if(c.length!=4){
	  			layer.msg("请输入正确的验证码",2,-1);
	  			return ;
	  		}
	  		data.verify_code=c;
	  	}
	  	$.extend(data,postData);
	  	data.content = content;
	  	data.title = title;
		remote.qa.prev(data);
		$this.addClass("submit-loading").val("正在发布...");
		$.ajax({
			url:"/course/ajaxsaveques",
			data:data,
			type:"post",
			dataType:"json",
			success:function(data){
				if(data.result==0){
				  	layer.msg('发布成功!', 2, -1);
				  	GetListData.qa.load();
			    	UE.getEditor("discuss-editor").setContent("");
			    	$('#js-qa-title').val("");
			    	remote.qa.reset();
			    	$("#js-discuss-btm .verify-code").remove();
				}
				else if(data.result==-103001){
					//verify code;
					if($("#js-discuss-btm .verify-code").length) return ;
					$("#js-discuss-btm").append([
		                '<div class="verify-code l">',
		                    '<input type="text" maxlength="4" class="verify-code-ipt">',
		                    '<img src="/wenda/getverifycode?',Math.random(),'" >',
		                    '<span class="verify-code-around">看不清换一换</span>',
		                '</div>'
		            ].join(""));

				}
				else{
					layer.msg(data.msg, 2, -1);
				}
			},
			complete:function(){
				$this.removeClass("submit-loading").val("发布");
			}
		})

	});

	//笔记框
	$('#js-note-input-fake').on({
		focusin: function() {
			$(this).addClass('ipt-fake-focus')
		},
		focusout: function() {
			$(this).removeClass('ipt-fake-focus');
		},
		keyup: function() {
			var len = $.trim($('#js-note-textarea').val()).length;
			if(len > 1000) {
				$(this).addClass('ipt-fake-error');
				$('#js-note-limit').addClass('limit-overflow');
			}
			else{
				$(this).removeClass('ipt-fake-error');
				$('#js-note-limit').removeClass('limit-overflow');
			}
			$('#js-note-limit').text(len);
		}
	});
    //发笔记
    $('#js-note-submit').on('click',function(){
    	var $this=$(this),
    		data={};
    	if($this.hasClass("submit-loading")) return ;
    	data.content=$.trim($('#js-note-textarea').val());
    	if(!data.content.length||data.content == $("#js-note-textarea").attr("placeholder")){
	 		layer.msg('请输入内容', 2, -1);
	  		return;
	  	}
	  	if(data.content.length>0 && data.content.length < 3){
			layer.msg('输入不能小于3个字符', 2, -1);
			return;
		}
		if(data.content.length > 1000){
			layer.msg('输入不能超过1000个字', 2, -1);
			return;
		}

    	$.extend(data,postData);
    	remote.note.prev(data);
		data.is_shared=$('#js-isshare').is(':checked')?1:0; //是否分享
		$this.addClass("submit-loading");
		$.ajax({
			url:"/course/addnote",
			type:"post",
			dataType:"json",
			data:data,
			success:function(data){
				$this.removeClass("submit-loading");
				if(data.result==0){
			   		layer.msg('发布成功', 2, -1);
			 		GetListData.note.load();
			 		$('#js-note-limit').text(0);
			 		$('#js-note-textarea').val("").blur(); //blur to trigger fake placeholder
	        	}
			 	else{
				  	layer.msg(data.msg, 2, -1);
				}
				remote.note.success(data);
				remote.note.reset();
			}
		});
	});

	$("#js-note-textarea").on("keyup change",function(){
		$('#js-note-text-counter').find('em').text($.trim($(this).val()).length);//how to handle space?
	});

	//截图动作
   	$('.shot-btn').on('click',function(){
	   shot.screenShot()
	})



	/*换一换同学*/
	var getUser=function(){
	  	$.post('/course/classmates', {cid:course_id, total:6}, function(data){
			$('#js-class-mate').empty();
			var html='';
			$(data).each(function(i, user) {
				html+=[
					'<li class="clearfix">',
						'<a class="mate-avator" href="/space/u/uid/',user.uid,'" target="_blank"><img src="',user.portrait,'" width="40" height="40"/></a>',
						'<div class="mate-info">',
							'<a href="/space/u/uid/',user.uid,'" target="_blank">',user.nickname,'</a>',
							'<span>',user.job_title,'</span>',
						'</div>',
					'</li>'
				].join("");
				//$('<li><h3><a href="/space/u/uid/'+user.uid+'" target="_blank">'+user.nickname+'</a></h3><em>'+user.job_title+'</em></li>').appendTo($('.users'));
			});
			$('#js-class-mate').html(html);
	   	});
	};

	getUser();

	$('.js-ch-mate').click(function(e){
		e.preventDefault();
		getUser();
	});


	$("#js-note-textarea").on("keyup change",function(){
		var $this=$(this);
		$("#js-note-text-counter em").text($.trim($this.val()).length);
	});
	//下载统计
	$('.downlist a').click(function(){
		var id=$(this).attr("data-id");
		$.ajax({
			url:"/course/ajaxdownloadlog",
			type:"post",
			data:{
				id:id
			}
		})
	})


	//verify code
    $(document).on("click",".verify-code-around",function(){
        var $img=$(this).prev("img");
        $img.attr("src",$img.attr("src").replace(/\?\S*/,"?"+Math.random()));
    });

    //toggle follow course;
    $('.js-btn-follow').click(function(e){
    	var $this = $(this),
    		url = '/space/ajaxfollow',
    		followed;
    	if($this.hasClass('follow-submiting')) return ;
    	if($this.hasClass('course-followed')) {
    		url = '/space/ajaxfollowcancel';
    		followed = 1;
    	}
    	$this.addClass('follow-submiting');

    	$.ajax({
			type: "post",
			url: url,
			dataType:"json",
			data: {
				course_id:$this.attr('data-id')
			},
			success: function(res) {
				if(res.result==0) {
					if(followed) {
						$this.removeClass('course-followed').addClass('course-follow').attr('title', '关注此课程')
						.find('.icon').removeClass('icon-heart-revert').addClass('icon-heart');
					}else{
						$this.removeClass('course-follow').addClass("course-followed").attr('title', '取消关注')
						.find('.icon').removeClass('icon-heart').addClass('icon-heart-revert');
					}
				}
				else {
					layer.msg('操作失败，请稍后再试', 1, 1);
				}
			},
			error: function() {
				layer.msg('网络错误，请稍后再试', 1, 1);
        	},
        	complete: function() {
        		$this.removeClass('follow-submiting');
        	}
		});
    	e.preventDefault();
    });

    //toggle note content
    $('#noteLoadListData').on('click', '.js-toggle-content', function(e) {
    	var $this = $(this),
    		state = $this.attr('data-state');
    	if(state === 'expanded') {
    		$this
    		.text('[ 查看全文 ]')
    		.attr('data-state','collapsed')
    		.parent().css({
    			position: 'absolute'
    		})
    		.closest('.js-notelist-content').css({
    			maxHeight: '168px' //28*6
    		});
    	}
    	else {
    		$this
    		.text('[ 收起全文 ]')
    		.attr('data-state','expanded')
    		.parent().css({
    			position: 'static'
    		})
    		.closest('.js-notelist-content').css({
    			maxHeight: 'none'
    		});
    	}
    	e.preventDefault();
    });

//分享
var chaptername=$("#sectionlist h3").text(),   //章名称
	sectionname=$(".videohead h1 span b").text();
var html="我正在慕课网学习一门很不错的课程【"+chaptername+""+"】我已学习至"+sectionname+",分享给想学习实用IT技能的同学!"    //节名称
var imgPic = $('#coursePic img')[0].src;
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":html,"bdMini":"2","bdMiniList":false,"bdPic":imgPic,"bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];


});
