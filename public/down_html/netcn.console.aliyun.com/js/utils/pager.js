var pager = {					
		
		url : "",
		createParams : null,
		renderTBody : null,
		jessionID: $("#userIDcommonMaster").val(),
		showPageIndexItem:3,//展示页码数，四个
		pageIndex : 1,
		totalPageCount : 0,

		goButton : $("#goBtn"), //跳转按钮		
		
		btnSearch : $("#btnSearch"), //查询按钮
		ckSelectAll : $("#ckSelectAll"), //选择全部checkBox
		ckSelectAll2 : $("#ckSelectAll2"), //选择全部checkBox
		
		init : function(url, createParams, renderTBody) {
			var me = pager;
			
			me.url = url;
			me.createParams = createParams;
			me.renderTBody = renderTBody;

			me.goButton.click(me.goButtonClickHandler);
			

			$("#gotoPageNo").keydown(function(e) {
					var curkey = e.which;
					if (curkey == 13) {
						me.goButtonClickHandler();
						return false;
					}
				}); 

			
			me.btnSearch.click(me.btnSearchClickHandler);				
			me.ckSelectAll.click(me.checkedAll);
			me.ckSelectAll2.click(me.checkedAll2);
			try{
				var cookieKey = me.urlPagerCookie(me.jessionID,me.url);
				var urlPager = $.cookie(cookieKey);
				if(urlPager == null || urlPager==''){
					me.getData(1);
				}else{
					me.getData(urlPager);
					$.cookie(cookieKey,urlPager,{ expires: 5 });
				}
			}catch(e){
				me.getData(1);
			}
		},
		
		reload : function() {
			var me = pager;
			
			me.getData(1);
		},
		
		
		/*-------------记录url的cookie key生成函数----------------------*/
		urlPagerCookie : function(jessionID, url){
			var reg = new RegExp("/","g");
			return jessionID + url.replace(reg,"-");
		},
		
		
		/*----------------------分页相关函数 开始------------------------*/

		goButtonClickHandler : function() {
			var me = pager;
			var gotoPageNo = $("#gotoPageNo").val();
			
			var type = "^[0-9]*[1-9][0-9]*$"; 
	        var re = new RegExp(type);
	        
			if(gotoPageNo == "" || gotoPageNo.match(re) == null || gotoPageNo == 0 || gotoPageNo > me.totalPageCount) {
				alert("请输入正确的页码!");
				return false;
			}
			
			me.gotoPage(gotoPageNo);
		},
		
		renderPagedLinks : function(pagedList) {
			var me = pager;

			me.pageIndex = pagedList.pageIndex;
			me.totalPageCount = pagedList.totalPageCount;
			//fix bug: 共0页，第一页。
			if(me.totalPageCount==0){
				me.totalPageCount = 1;
			}

			$(".pagination-info").html("共有"+pagedList.totalCount+"条，每页显示："+pagedList.pageSize+"条");
			$("#totalCount").val(pagedList.totalCount);

			var paginationHtml = new Array();
			paginationHtml.push('<li '+(me.pageIndex <= 1?'class="disabled"':'')+' page-index="1"><a>«</a></li>');
			paginationHtml.push('<li '+(me.pageIndex <= 1?'class="disabled"':'')+' page-index="'+(me.pageIndex-1)+'"><a>‹</a></li>');

			var minPageIndex = me.pageIndex - parseInt(me.showPageIndexItem/2);
			if(minPageIndex < 1){
				minPageIndex = 1;
			}

			var maxPageIndex = minPageIndex + me.showPageIndexItem;
			if(maxPageIndex > me.totalPageCount){
				maxPageIndex = me.totalPageCount;
			}

			for(var i = minPageIndex; i <= maxPageIndex; i ++){
				paginationHtml.push('<li '+(i == me.pageIndex ? 'class="active"':' ')+' page-index="'+i+'"><a >'+i+'</a></li>')
			}

			paginationHtml.push('<li'+(me.pageIndex >= me.totalPageCount?' class="disabled"':'')+'  page-index="'+(me.pageIndex+1)+'"><a>›</a></li>');
			paginationHtml.push('<li'+(me.pageIndex >= me.totalPageCount?' class="disabled"':'')+' page-index="'+me.totalPageCount+'"><a>»</a></li>');



			$(".pagination").html(paginationHtml.join(''));

			$(".pagination li").click(function(){
				var pageIndex = parseInt($(this).attr("page-index"));
				if(pageIndex!=me.pageIndex && pageIndex > 0 && pageIndex<=me.totalPageCount){
					me.gotoPage(pageIndex);
				}
			});
		},
		
		gotoPage : function(pageIndex) {
			var me = pager;
			
			me.getData(pageIndex);
		},
		
		/*----------------------分页相关函数 结束------------------------*/
		
		
		/*----------------------列表相关函数 开始------------------------*/
		btnSearchClickHandler : function() {
			var me = pager;
			
			//确保验证函数是hiValidator
			if(!(typeof(hiValidator) == "undefined")) {
				if(!hiValidator.form()) {
					return;
				}
			}
							
			me.getData(1);
		},
		
		checkedAll : function() {
			var me = pager;
			
			if(me.ckSelectAll.is(":checked")) {
				$("input:enabled[name='ckbox']").each(function() {
					$(this).attr("checked", true);
				});
                me.ckSelectAll2.attr("checked" ,true);
			} else {
				$("input:enabled[name='ckbox']").each(function() {
					$(this).attr("checked", false);
				});
                me.ckSelectAll2.attr("checked" ,false);
			}
		},
		
		checkedAll2 : function() {
			var me = pager;

			if(me.ckSelectAll2.is(":checked")) {
				$("input:enabled[name='ckbox']").each(function() {
					$(this).attr("checked", true);
				});
                me.ckSelectAll.attr("checked" ,true);
			} else {
				$("input:enabled[name='ckbox']").each(function() {
					$(this).attr("checked", false);
				});
                me.ckSelectAll.attr("checked" ,false);
			}
		},
		
		getData : function(pageIndex) {
			var me = pager;
			
			var cookieKey = me.urlPagerCookie(me.jessionID,me.url);
			$.cookie(cookieKey,pageIndex,{ expires: 5 });
			
			$(".customerCenterTabPanel").mask('');
			$.post(me.url, me.classToString(me.createParams(pageIndex)),
					function(pagedList) {
						me.renderTBody(pagedList.list);
						me.renderPagedLinks(pagedList);	 
						$(".customerCenterTabPanel").unmask();
					});
			
		},
		
		//该函数作用为：将ajax参数由类方式转换成a=1&b=2的方式，否则使用encodeURIComponent转码后的中文
		//在controller中必须采用转码才能变成中文
		classToString : function(data) {
			var info = "";
			$.each(data, function(key, value) {
					info += key + "=" + value + "&";
					});
			return info;
		},
		
		getSelectedIDs : function() {
			var checkedIDs = [];
			$("input:checked[name='ckbox']").each(function() {
				checkedIDs.push($(this).val());
			});
			
			return checkedIDs;
		}
		
		/*----------------------列表相关函数 结束------------------------*/
};