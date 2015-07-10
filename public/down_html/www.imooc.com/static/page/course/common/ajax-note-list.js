define(function(require,exports){
	require('/static/css/course_note.css');
	require("/static/lib/dot/1.0.0/doT.js");
	var tpl=require("/static/template/note-list.tpl");
	var page=require("/static/component/base/util/paging.js");
	var settings,
		pageRander,
		$itemContainer,
		$pageContainer,
		myExports;
	//console.log(tplDef)
	
	/*
	options:
	{
		container:"selector",
		onBeforeLoad:"function",
		onLoaded:"function",
		params:{server params},
		def:{doT template def},
		onFinish:"function" //fired after render the content
	}*/

	function note(options){
		if(myExports) return myExports;
		var $ctn=$(options.container);
		settings=options;
		settings.params||(settings.params={});
		($itemContainer=$("<div id='course_note' class='course_note'></div>")).appendTo($ctn);
		($pageContainer=$("<div class='page note-list-page'></div>")).appendTo($ctn);


		tpl=doT.template(tpl,null,settings.def||tplDef);

		pageRander=page.setup({
			container:$pageContainer,
			delegate:'.note-list-page a',
			pageClick:function(e){
				load($(this).attr("data-page"))
			}
		});


		$(document).off("click.imagetoggle").on("click.imagetoggle",".answerImg",function(){
			$(this).hide().siblings(".answerImg").show();
		});

		$(document).off("click.shownotecode").on("click.shownotecode",".js-show-node-code",function(){
			var id=$(this).attr("data-id");
			require.async('./view_code',function(ViewCode){
				ViewCode.init('/course/viewnotecode',id,{})
			});	
		});

		$(document).on("click",".Jpraise",function(e){
			e.preventDefault();
			var $this=$(this),
				f,id;
			if (!OP_CONFIG.userInfo) {
			    require.async('login_sns',function(login) {
	                login.init();
	            });
				return 
		    }
			f=$this.hasClass("on");
			id=$this.attr("data-id");
			$.ajax({
				url:"/course/"+(f?"cancelpraise":"praisenote"),
				data:{
					id:id,
					mid:pageInfo.mid
				},

				dataType:"json",
				success:function(data){
					if(data.result==0){
						var num =+$this.text();
						$this.find("em").text(num+(f? -1:1));
						//$this.removeClass('J_PraiseNum');
						$this[f?"removeClass":"addClass"]('on').attr(f?"取消赞":"赞");
						$this.find('span')[f?"removeClass":"addClass"]('on');
					} 
				},
				error:function(){

				}
			});
		});

		$(document).on("click",".Jcollect",function(e){
			e.preventDefault();
			var $this=$(this),ids;
			if($this.hasClass("on")) return ;
			if (!OP_CONFIG.userInfo) {
			    require.async('login_sns',function(login) {
	                login.init();
	            });
				return 
		    }


		    ids=$this.attr("data-id").split("|");
		    if(OP_CONFIG.userInfo&&OP_CONFIG.userInfo.uid===ids[1]){
		    	alert("亲亲\""+(OP_CONFIG.userInfo.nickname||"")+"\"，别采集自己的笔记哟~！");
		    	return ;
		    }
		    $.ajax({
		    	url:"/course/collectnote",
		    	data:{
		    		id:ids[0],
		    		mid:pageInfo.mid
		    	},
				dataType:"json",
				success:function (data){
					if(data.result==0){
						$this.find("em").text(+$this.text()+1);
						$this.addClass('on').attr('title', '已采集').find("span").addClass('on');
					}
				}

		    });
		})

		return myExports={
			load:function(page){
				load(+page);
			}
		}
	}
	// this hook
	//
	function loaded(data){
		if(data.page_total==0&&(!data.list||!data.list.length)){
			$itemContainer.html("<div class='unnote'><span></span><p>此节暂无同学记录过笔记</p></div>");
			return false;
		}
	}

	function load(page){
		var data=$.extend({},settings.params);
		data.page=page||1;
		data.r=Math.random();
		$.ajax({
			url:"/course/mynote",
			dataType:"json",
			data:data,
			success:function(data){
				if(data.result===0){
					data=data.data;
					//console.log(tpl(data))
					//data.list=[];
					//data.page_total=0;
					if(loaded(data)===false) return;
					$(data.list).each(function(index,obj){
						data.list[index].content=(obj.content.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,"$1<br>$2"));
					})
					$itemContainer.html(tpl(data));
					pageRander(+data.page_current,+data.page_total);
				}

				
			},
			error:function(){
				//alert(" 服务器错误，稍后重试");
			}
		})
	}

	return note;
});