define(function(require,exports){
    require('/static/css/ques.css');
    require("/static/lib/dot/1.0.0/doT.js");
    var tpl=require("/static/template/pl-list.tpl");
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

    function pl(options){
        if(myExports) return myExports;
        var $ctn=$(options.container);
        settings=options;
        settings.params||(settings.params={});
        ($itemContainer=$("<div class='pl-container'></div>")).appendTo($ctn);
        ($pageContainer=$("<div class='page pl-list-page'></div>")).appendTo($ctn);

        tpl=doT.template(tpl,null,settings.def||tplDef);

        pageRander=page.setup({
            container:$pageContainer,
            delegate:'.pl-list-page a',
            pageClick:function(e){
                load($(this).attr("data-page"))
            }
        });

        //js-pl-praise
        $(document).on("click",".js-pl-praise",function(e){
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
                url:"/course/commentsupport",
                data:{
                    id:id
                },
                type:"post",
                dataType:"json",
                success:function(data){
                    if(data.result==0){
                        var num =+$this.text();
                        $this.find("span").text(num+1);
                        //$this.removeClass('J_PraiseNum');
                        $this.addClass('on').removeClass("js-pl-praise");
                        $this.find('i').addClass('on');
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
            $itemContainer.html("<p class='pl-none'><span></span>此节暂无同学评论</p>");
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
            url:"/course/getcomment",
            dataType:"json",
            data:postData,
            success:function(data){
                //console.log(tpl(data.data))

                if(data.result===0){
                    data=data.data;
                    //data.list=[]; 
                    //data.page_total=0;
                    //data.list[0].lang="javascript";
                    $.each(data.list, function(i,list){
                        list.description=list.description.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,"$1<br>$2"); //nl2br
                    });
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

    return pl;
});