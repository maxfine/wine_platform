$(function () {

    window.hichina.customercenter.SetCustomerCenterH4Hide();

    //取cookie
    var CustomerCenterMenuH5 = parseInt($.cookie('CustomerCenterMenuH5'));

    //根据cookie选中
    hichina.customercenter.SetCustomerCenterMenuH5(CustomerCenterMenuH5);

    $("#obpsiderNav > ul > li > h4").click(function () {
        var sindex = $("#obpsiderNav > ul > li > h4").index($(this));
        hichina.customercenter.SetCustomerCenterMenuH4(sindex);
    });

    $("#obpsiderNav > ul > li > ul > li > h5").click(function () {
        var sindex = $("#obpsiderNav > ul > li > ul > li > h5").index($(this));
        hichina.customercenter.SetCustomerCenterMenuH5(sindex);
    });

});

function MenuURL(srcUrl, OpenType) {
    if (1 == OpenType) {
        window.open(srcUrl);
    }
    else {
        window.location.href = srcUrl;
    }
    return;
}


(function() {
    if (window.hichina == undefined)
        window.hichina = {};

    window.hichina.customercenter = {};

    //设置选中菜单
    window.hichina.customercenter.SetCustomerCenterMenuA = function(txt) {
        $("#obpsiderNav > ul > li > ul > li a").each(function() {
            var tt = $.trim($(this).text());
            if (tt == txt) {
                $(this).parent().addClass("active");
                var p = $(this).parent().parent().parent();
                var psindex = $("#CustomerCenterMenu > ul > li ").index(p);
            }
            else{
                $(this).parent().removeClass("active");
            }

            window.hichina.customercenter.SetCustomerCenterH4Hide();

        });
    },

        //根据cookie，设置会员中心左侧菜单栏的展开状态
        window.hichina.customercenter.SetCustomerCenterH4Hide = function(){
            $("#CustomerCenterMenu > ul > li > h4").each(function(index, value){
                var cookieName = window.hichina.customercenter.CustomerCenterH4CookieName(index);
                var thisH4 = $("#CustomerCenterMenu > ul > li > h4:eq(" + index + ")");
                var thisUl = $(">ul", thisH4.parent());
                if($.cookie(cookieName)!=null){
                    thisH4.addClass("se");
                    thisUl.addClass("hide");
                }
                else{
                    thisUl.removeClass("hide");
                    thisH4.removeClass("se");
                }
            });
        },


        window.hichina.customercenter.CustomerCenterH4CookieName = function(index){
            var userID = $("#userIDcommonMaster").val();
            return userID+"h4-"+index ;
        },

        //选中会员菜单,如果隐藏了，则设置cookie，否则删除cookie，cookie的格式为 userID + "h4-" +index
        //index 是h4标签的相对位置。
        window.hichina.customercenter.SetCustomerCenterMenuH4 = function(sindex) {

            var cookieName = window.hichina.customercenter.CustomerCenterH4CookieName(sindex);

            var thisH4 = $("#obpsiderNav > ul > li > h4:eq(" + sindex + ")");
            var thisUl = $(">ul", thisH4.parent());
            var thisLi = thisH4.parent();
            var thisSpan = thisH4.children();

            if (thisUl.is(':visible')) {

//        	thisUl.addClass("hide");
//            thisH4.addClass("se");
                thisLi.addClass('obpsider-whole-li');
                thisLi.removeClass('obpsider-whole-li-bottom');
                thisSpan.removeClass('icon-up3');
                thisSpan.addClass('icon-down3');
                $.cookie(cookieName,'hide',{ expires: 7, path: '/'});
            }
            else {
                //设置cookie
                //thisUl.slideDown();
//        	thisUl.removeClass("hide");
//            thisH4.removeClass("se");
                thisLi.addClass('obpsider-whole-li-bottom');
                thisLi.removeClass('obpsider-whole-li');
                thisSpan.addClass('icon-up3');
                thisSpan.removeClass('icon-down3');
                $.cookie(cookieName,null,{path: '/'});
            }
        },

        // 选中产品购买子项目
        window.hichina.customercenter.SetCustomerCenterMenuH5 = function(sindex) {
            var thisH5 = $("#CustomerCenterMenu > ul > li > ul > li > h5:eq(" + sindex + ")");
            var thisUl = $(">ul", thisH5.parent());

            $("#CustomerCenterMenu > ul > li > ul > li > ul").hide();//.slideUp();
            $("#CustomerCenterMenu > ul > li > ul > li > h5").removeClass("se");

            if (thisUl.is(':visible')) {
                //thisUl.slideUp();
                thisUl.hide();
                thisH5.removeClass("se");
            }
            else {
                //thisUl.slideDown();
                thisUl.show();
                thisH5.addClass("se");
                //设置cookie
                $.cookie('CustomerCenterMenuH5', null);
                $.cookie('CustomerCenterMenuH5', null, { path: '/' });
                $.cookie('CustomerCenterMenuH5', sindex, { expires: 7, path: '/' });
            }
        }

})();