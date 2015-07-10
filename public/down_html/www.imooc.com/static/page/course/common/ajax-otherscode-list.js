define(function(require,exports){
	require('/static/css/ques.css');
	require("/static/lib/dot/1.0.0/doT.js");
	var tpl=require("/static/template/otherscode-list.tpl");
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

	function othterscode(options){
		if(myExports) return myExports;
		var $ctn=$(options.container);
		settings=options;
		settings.params||(settings.params={});
		($itemContainer=$("<div class='othterscode-container'></div>")).appendTo($ctn);
		($pageContainer=$("<div class='page othterscode-list-page'></div>")).appendTo($ctn);

		tpl=doT.template(tpl,null,settings.def||tplDef);

		pageRander=page.setup({
			container:$pageContainer,
			delegate:'.othterscode-list-page a',
			pageClick:function(e){
				load($(this).attr("data-page"))
			}
		});
		$(document).off("click.showotherscode").on("click.showotherscode",".otherscode-code",function(){
			var id=$(this).attr("data-id");
			require.async('./view_code',function(ViewCode){
				ViewCode.init('/course/viewexamcode',id,{})
			});	
		});

		//js-otherscode-praise
		$(document).on("click",".js-otherscode-praise",function(e){
			e.preventDefault();
			var $this=$(this),
				f,id;
			if (!OP_CONFIG.userInfo) {
			    require.async('login_sns',function(login) {
	                login.init();
	            });
				return 
		    }
			id=$this.attr("data-id");
			$.ajax({
				url:"/course/codesupport",
				data:{
					id:id
				},
				dataType:"json",
				success:function(data){
					if(data.result==0){
						var num =+$this.text();
						$this.find("em").text(num+1);
						//$this.removeClass('J_PraiseNum');
						$this.addClass('on').removeClass("js-otherscode-praise");
						$this.find('span').addClass('on');
					} 
				},
				error:function(){

				}
			});
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
			$itemContainer.html("<p class='othterscode-none'><span></span>此节暂无同学的提交代码</p>");
			return false;
		}		
	}
	
	function load(page,order){
		var postData;
		order&&(settings.params.order=order);
		postData=$.extend({},settings.params);
		postData.page=page||1;
		//prevLoad(postData);
		postData.r=Math.random();
		$.ajax({
			url:"/course/otherscode",
			dataType:"json",
			data:postData,
			success:function(data){
				//console.log(tpl(data.data))
				if(data.result===0){
					data=data.data;
					//data.list=[]; 
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

	return othterscode;
});