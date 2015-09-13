/**
 * 登录弹框
 * @param  {object} opt 
 * @author HuangBingcheng
 */

/*opt = {
    loginBtn: '#xxx',  登录按钮，可传字符串，DOM对象，jQuery对象
    parent: '#xxx',    登录框会插入到此元素下，默认body
    cbLink: 'http://xx.com',  登录后iframe跳转页面
    cbFn: fn;          点击登录按钮后要做的事情
}*/
function login(opt) {
    if (!$(opt.loginBtn)) return;

    var loginBtn = opt.loginBtn,
        parent = $(opt.parent) || $('body'),
        cbLink = opt.cbLink || location.protocol.toLowerCase() + '//www.sogou.com/login/qq_login_callback_page.html',
        cbFn = opt.cbFn;

    $(loginBtn).bind('click.login', function() {
        if($(this).attr("id") == 'changeSkin'){
            var now = new Date();
            now.setMinutes(now.getMinutes() + 1); //cookie失效1分钟
            var expires = now.toUTCString();
            document.cookie = ["skinLogin=1", ";expires=", expires, ";domain=.www.sogou.com;path=/"].join("");
        }
        createLoginBox(parent, cbLink);

        if (cbFn) {
            cbFn();
        }
        //fix ie6 iframe 空白
        return false;
    });
}

function getScrollTop() {
    return document.documentElement.scrollTop || document.body.scrollTop;
}

function createLoginBox(parent, cbLink) {
    var qqLoginUrl = 'https://account.sogou.com/connect/login?provider=qq&client_id=2017&ru=' + encodeURIComponent(cbLink) + '&hun=0&oa=0';
    if(location.protocol.toLowerCase() == 'https:'){ //https新窗口打开登录
        window.open(qqLoginUrl, "", 'width=510, height=500, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no');
    }else{
        if (!createLoginStyle) return;

        createLoginStyle();
        var $body = $('body'),
        pageHeight = $body.height(),
        maskLayer = $('<div/>').addClass('login-skin'),
        loginBox = $('<div/>').addClass('login-pop'),
        iframe = $('<iframe/>').attr('src', qqLoginUrl).css({
            "width": 510,
            "height": 500,
            "border": 0
        }),
        close = $('<a/>').attr({
            "id": "loginCloseBtn",
            "href": "javascript:void(0)",
            "class": "del"
        });

        maskLayer.css('height', pageHeight);
        loginBox.css('top', 113 + getScrollTop());

        loginBox.append(close);
        loginBox.append(iframe);

        parent.append(maskLayer);
        parent.append(loginBox);

        $(window).bind('scroll', function() {
            loginBox.stop().animate({top: 133 + getScrollTop()}, 500);

            if($body.height() !== pageHeight) {
                maskLayer.css('height', $body.height());
                pageHeight = $body.height()
            }
        });

        close.bind('click.closebox', function() {
            maskLayer.remove();
            loginBox.remove();
        });
    }
}

function createLoginStyle() {
    if ($('#loginStyle').length > 0) return;

    var loginCSS = '.login-skin{position: absolute;top:0;left:0;width: 100%;height: 100%;z-index: 2100;background-color: #000;opacity:0.4;filter:alpha(opacity=40);}'
            + '.login-pop{background-color: #fff;border: 1px solid #ebebeb;width: 510px;height: 500px;position: absolute;margin-left:-225px;left: 50%;top: 113px;font-family: Microsoft YaHei;z-index: 2200;}'
            + '.del{position: absolute;width: 20px;height: 20px;z-index: 4;top: 13px;right: 13px;display: block;background: url(/images/skin/del.gif) no-repeat;_background: url(/images/skin/del.gif) no-repeat;background-position: 0 0;}'
            + '.del:hover{background-position: -41px 0;}';

    var loginStyle = $('<style/>').attr({id: 'loginStyle', type: 'text/css'});

    $('body').append(loginStyle);

    if (loginStyle[0].styleSheet) { //for ie   
        loginStyle[0].styleSheet.cssText = loginCSS;
    } else { //for w3c   
        loginStyle[0].appendChild(document.createTextNode(loginCSS));
    }
}