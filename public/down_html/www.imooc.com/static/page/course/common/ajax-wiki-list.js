define(function(require,exports){
	require('/static/css/course_wiki.css');
	require("/static/lib/dot/1.0.0/doT.js");
	var tpl=require("/static/template/wiki-list.tpl");
	var page=require("/static/component/base/util/paging.js");
	var settings,
		pageRander,
		$itemContainer,
		$pageContainer,
		myExports;//single instance
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

	function wiki(options){
		var $ctn;

		if(myExports) return myExports;

		$ctn=$(options.container)
		settings=options;
		settings.params||(settings.params={});
		($itemContainer=$("<div id='course_wiki' class='course_wiki'></div>")).appendTo($ctn);
		($pageContainer=$("<div class='page wiki-list-page'></div>")).appendTo($ctn);

		tpl=doT.template(tpl,null,settings.def||tplDef);

		pageRander=page.setup({
			container:$pageContainer,
			delegate:'.wiki-list-page a',
			pageClick:function(e){
				load($(this).attr("data-page"))
			}
		});

		
		return myExports={
			load:function(page){
				load(page);
			}
		}
	}
	// this hook
	//
	function loaded(data){
		if(data.page_total==0&&!data.list.length){
			$itemContainer.html("<div class='unwiki'><span></span><p>此节暂无WiKi词条关联</p></div>");
			return false;
		}
	}

	function load(page){
		var data=$.extend({},settings.params);
		data.page=page||1;
		postData.r=Math.random();
		$.ajax({
			url:"/course/ajaxgetwiki",
			dataType:"json",
			data:data,
			success:function(data){
				//console.log(tpl(data.data))

				if(data.result===0){
					data=data.data;
					//data.list=[];
					//data.page_total=0;
					if(loaded(data)===false) return;
					$itemContainer.html(tpl(data));
					pageRander(+data.page_current,+data.page_total);
				}

				
			},
			error:function(){
				//alert(" 服务器错误，稍后重试");
			}
		})
	}

	return wiki;
});