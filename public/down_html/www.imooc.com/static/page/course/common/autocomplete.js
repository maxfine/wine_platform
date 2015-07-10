define(function(require, exports, module){
//发问题时提供输入关联同类型问题
    var timer=null;
    var currIndex=-1;

    var searchFun=function(obj){
        var $this=obj;
        (timer) && clearTimeout( timer );                             
        timer=setTimeout(function(){
            if($.trim($this.val())){
                $.ajax({
                    type: "get",
                    url: "/index/ajaxsearchbbs",
                    dataType:"json",
                    data: {
                        words:$.trim($this.val())
                    },
                    success: function(res){
                        currIndex=-1;
                        var bbslist=res.data.data;
                        if(bbslist) {
                            var str="<dt>类似的问题</dt>";
                            if(bbslist.length !=0){
                                for(var i=0;i<bbslist.length;i++){
                                    var course = bbslist[i];
                                    var name = course.title||course.description;
                                    name=$("<div/>").text(name).html()
                                    var id = course.id;
                                    var subname = name.strLen()>80?name.subCHStr(0,70)+"..":name;
                                    var num = course.answers;
                                    var linkurl="/wenda/detail/"
                                    if(course.type_id==2){
                                        linkurl="/qadetail/"
                                        id=course.old_ques_id
                                    }
                                    var answer="";
                                    if(course.finished != 0){
                                        answer="已采纳回答"
                                    }
                                    if(course.last_t_id != 0){
                                        answer="老师回答"
                                    }
                                    if(course.finished != 0 && course.last_t_id != 0){
                                        answer="老师回答 已采纳回答"
                                    }
                                    str+='<dd title="'+name+'"><a  class="questiontitle" target="_blank" href="'+linkurl+id+'">'+subname+'<em>'+num+'个回答</em> <i>'+answer+'</i></a></dd>';
                                }
                            }
                            $(".send-area-result").html(str).css("z-index",99999).show();
                            $this.attr("data-old",$this.val());
                        }else{
                            $(".send-area-result").hide().html("");
                        }
                    }
                }); 
            }else{
                $(".send-area-result").hide().html("");
            }                    
       },400)
    }
    var searchListen=function(){
        var objs=$(".send-area-result dd").removeClass('oncurr')
        var keyword=""

        if(currIndex>-1){
            keyword=$(objs.get(currIndex)).addClass('oncurr').attr("title");
        }
    }

    var bindEvent=function(){
        $(".autocomplete").on(
            {'keydown': function (event) {
                (timer) && clearTimeout( timer );                     
                switch (event.keyCode) {
                    case 13://回车
                        if(currIndex > -1){
                            $(".send-area-result dd").eq(currIndex).find("a")[0].click();
                            return false;
                        }
                        var keyword =$.trim($(this).val());
                        if(!keyword) return false;
                        $(".send-area-result").hide().html("");
                        currIndex=-1;
                    break;
                    case 38:
                        currIndex=currIndex>-1?currIndex-1:$(".send-area-result dd").length-1
                        searchListen();
                    break;
                    case 40:
                        currIndex=currIndex<$(".send-area-result dd").length-1?currIndex+1:-1
                        searchListen();
                    break;
                    default:
                        searchFun($(this));
                }
            },
            'focus':function(){
                if($.trim($(this).val())) {
                    searchFun($(this));
                }
                
            },
            'blur':function(){
                setTimeout(function(){
                    $(".send-area-result").hide().html("");
                },200)
            }
        });

        $(".send-area-result").on({
            'mouseenter':function(event) {
                $(this).addClass('oncurr').siblings().removeClass('oncurr')
                currIndex=$(this).index();
            },
            'mouseleave':function(event) {
                $(this).removeClass('oncurr');
                currIndex = -1;
            }
        },'dd')
    }

    bindEvent();

//结束
})