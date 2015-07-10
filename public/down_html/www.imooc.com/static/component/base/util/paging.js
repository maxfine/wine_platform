define(function(require,exports){

  var range=2;


  var getPages=function(current,total){
    var min=Math.max(current-range,1),
        max=Math.min(current+range,total);
    max=min==1?Math.min(1+2*range,total):max;
    min=max==total?Math.max(max-2*range,1):min;
    //console.log(min,max);
    var html=[];
    if(current==min){
       html.push("<span class='disabled_page'>首页</span><span class='disabled_page'>上一页</span>");
    }
    else{
      html.push("<a href='javascript:void(0)' data-page='1'>首页</a>");
      html.push("<a href='javascript:void(0)' data-page='"+(current-1)+"'>上一页</a>");
    }
    for(var i=min;i<=max;i++){
      html.push("<a href='javascript:void(0)' data-page='"+i+"' "+(i==current?"class='active'":"")+">"+i+"</a>");
    }
    if(current==max){
      html.push("<span class='disabled_page'>下一页</span><span class='disabled_page'>尾页</span>");
    }
    else{
      html.push("<a href='javascript:void(0)' data-page='"+(current+1)+"'>下一页</a>");
      html.push("<a href='javascript:void(0)' data-page='"+total+"'>尾页</a>");
    }

    return html.join("");

  }
  return {
    setup:function(options){//container||selector,click delegate selector,click function
      var $container=$(options.container);
      $(document).on("click",options.delegate,options.pageClick);
      return function(current,total){
        if(total<=1){
           $container.html("");
           return ;
        }
        $container.html(getPages(current,total));
      }
    }
  }
});