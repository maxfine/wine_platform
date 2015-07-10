define(function(require,exports){
	require('/static/css/ques.css');
	require("/static/lib/dot/1.0.0/doT.js");
	var tpl=require("/static/template/discuss-list.tpl");
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

	function discuss(options){
		if(myExports) return myExports;
		var $ctn=$(options.container);
		settings=options;
		settings.params||(settings.params={});
		($itemContainer=$("<div class='answertabcon'></div>")).appendTo($ctn);
		($pageContainer=$("<div class='page discuss-list-page'></div>")).appendTo($ctn);

		tpl=doT.template(tpl,null,settings.def||tplDef);

		pageRander=page.setup({
			container:$pageContainer,
			delegate:'.discuss-list-page a',
			pageClick:function(e){
				load($(this).attr("data-page"))
			}
		});
		$(document).off("click.imagetoggle").on("click.imagetoggle",".answerImg",function(){
			$(this).hide().siblings(".answerImg").show();
		});
		$(document).off("click.showcode").on("click.showcode",".js-show-disscus-code",function(){
			var id=$(this).attr("data-id");
			require.async('./view_code',function(ViewCode){
				ViewCode.init('/course/viewquescode',id,{})
			});	
		});

		//tab
		var order=settings.params.order||"";
		$itemContainer.before("<div class='sortlist'> \
			<div class='ordertab'> \
				<a href='javascript:void(0)' hidefocus='true' data-order='1' class='quealltab "+(!order?"onactive":"")+"'>全部问答</a>\
				<a href='javascript:void(0)' hidefocus='true' data-order='2' class='quealltab "+(order==1?"onactive":"")+"'>精华问答</a>\
			</div>\
		</div>");
		$(document).on("click","[data-order]",function(e){
			e.preventDefault();
			var $this = $(this),
				cls = "onactive";
			if($this.hasClass(cls)) {
				return ;
			}
			$this.siblings("."+cls).removeClass(cls).end().addClass(cls);
			load(1,$this.attr("data-order"));
		});
		return myExports={
			load:function(page,order){
				load();
			}
		}
	}
	// this hook
	//
	function loaded(data){
		if(data.page_total==0&&!data.list.length){
			$itemContainer.html("<p class='unquestion'><span></span>此节暂无同学的问答</p>");
			$pageContainer.empty();
			return false;
		}
	}
	
	function load(page,order){
		var postData;
		order && (settings.params.t = order);
		postData=$.extend({},settings.params);
		postData.page=page||1;
		//prevLoad(postData);
		postData.r=Math.random();
		$.ajax({
			url:"/course/ajaxmediaques",
			dataType:"json",
			data:postData,
			success:function(data){
				//console.log(tpl(data.data))
				if(data.result===0){
					data=data.data;
					//data.list=[]; test case
					//data.page_total=0;
					//data.list[0].lang="javascript";
					if(loaded(data)===false) return;
					$itemContainer.html(tpl(data));
					pageRander(+data.page_current,+data.page_total);
				}
			},
			error:function(data){
				//if handle error message,be care the half xhr.
				//when xhr abort a requesting the error function fired.
				//window.reload can trigger this.
				
			}
		})
	}

	return discuss;
});