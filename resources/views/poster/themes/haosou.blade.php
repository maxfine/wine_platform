<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="shortcut icon" href="https://www.haosou.com/favicon.ico" type="image/x-icon" />
    <title>好搜 — 用好搜，特顺手</title>
    <style mce_bogus="1">
        body { margin: 0px;  }
        iframe {border: 0px;}
    </style>
    <style type="text/css" adt="123"></style>
    <style type="text/css" adt="123"></style>
    <script>
        if(!document.URL.match(/^http:\/\/v\.baidu\.com|http:\/\/music\.baidu\.com|http:\/\/dnf\.duowan\.com|http:\/\/bbs\.duowan\.com|http:\/\/newgame\.duowan\.com|http:\/\/my\.tv\.sohu\.com/)){
            (function() {
                Function.prototype.bind = function() {
                    var fn = this, args = Array.prototype.slice.call(arguments), obj = args.shift();
                    return function() {
                        return fn.apply(obj, args.concat(Array.prototype.slice.call(arguments)));
                    };
                };
                function A() {}
                A.prototype = {
                    rules: {
                        'youku_loader': {
                            'find': /^http:\/\/static\.youku\.com\/.*(loader|player_.*)(_taobao)?\.swf/,
                            'replace': 'http://swf.adtchrome.com/loader.swf'
                        },
                        'youku_out': {
                            'find': /^http:\/\/player\.youku\.com\/player\.php\/.*sid\/(.*)/,
                            'replace': 'http://swf.adtchrome.com/loader.swf?VideoIDS=$1'
                        },
                        'pps_pps': {
                            'find': /^http:\/\/www\.iqiyi\.com\/player\/cupid\/common\/pps_flvplay_s\.swf/,
                            'replace': 'http://swf.adtchrome.com/pps_20140420.swf'
                        },
                        /*'iqiyi_1': {
                         'find': /^http:\/\/www\.iqiyi\.com\/player\/cupid\/common\/.+\.swf$/,
                         'replace': 'http://swf.adtchrome.com/iqiyi_20140624.swf'
                         },
                         'iqiyi_2': {
                         'find': /^http:\/\/www\.iqiyi\.com\/common\/flashplayer\/\d+\/.+\.swf$/,
                         'replace': 'http://swf.adtchrome.com/iqiyi_20140624.swf'
                         },*/
                        'ku6': {
                            'find': /^http:\/\/player\.ku6cdn\.com\/default\/.*\/\d+\/(v|player|loader)\.swf/,
                            'replace': 'http://swf.adtchrome.com/ku6_20140420.swf'
                        },
                        'ku6_topic': {
                            'find': /^http:\/\/player\.ku6\.com\/inside\/(.*)\/v\.swf/,
                            'replace': 'http://swf.adtchrome.com/ku6_20140420.swf?vid=$1'
                        },
                        'sohu': {
                            'find': /^http:\/\/tv\.sohu\.com\/upload\/swf(\/p2p)?\/\d+\/Main\.swf/,
                            'replace': 'http://www.adtchrome.com/sohu/sohu_20150104.swf'
                        },
                        'sohu2':{
                            'find':/^http:\/\/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\/testplayer\/Main0?\.swf/,
                            'replace':'http://www.adtchrome.com/sohu/sohu_20150104.swf'
                        },
                        'sohu_share': {
                            'find': /^http:\/\/share\.vrs\.sohu\.com\/my\/v\.swf&/,
                            'replace': 'http://www.adtchrome.com/sohu/sohu_20150104.swf?'
                        },
                        'sohu_sogou' : {
                            'find': /^http:\/\/share\.vrs\.sohu\.com\/(\d+)\/v\.swf/,
                            'replace': 'http://www.adtchrome.com/sohu/sohu_20150104.swf?vid=$1'
                        },
                        'letv': {
                            'find': /^http:\/\/player\.letvcdn\.com\/.*p\/.*\/newplayer\/LetvPlayer\.swf/,
                            'replace': 'http://swf.adtchrome.com/20150110_letv.swf'
                        },
                        'letv_topic': {
                            'find': /^http:\/\/player\.hz\.letv\.com\/hzplayer\.swf\/v_list=zhuanti/,
                            'replace': 'http://swf.adtchrome.com/20150110_letv.swf'
                        },
                        /*'letv_duowan': {
                         'find': /^http:\/\/assets\.dwstatic\.com\/video\/vpp\.swf/,
                         'replace': 'http://yuntv.letv.com/bcloud.swf'
                         },*/
                        '17173_in':{
                            'find':/http:\/\/f\.v\.17173cdn\.com\/(\d+\/)?flash\/PreloaderFile(Customer)?\.swf/,
                            'replace':"http://swf.adtchrome.com/17173_in_20150522.swf"
                        },
                        '17173_out':{
                            'find':/http:\/\/f\.v\.17173cdn\.com\/(\d+\/)?flash\/PreloaderFileFirstpage\.swf/,
                            'replace':"http://swf.adtchrome.com/17173_out_20150522.swf"
                        },
                        '17173_live':{
                            'find':/http:\/\/f\.v\.17173cdn\.com\/(\d+\/)?flash\/Player_stream(_firstpage)?\.swf/,
                            'replace':"http://swf.adtchrome.com/17173_stream_20150522.swf"
                        },
                        '17173_live_out':{
                            'find':/http:\/\/f\.v\.17173cdn\.com\/(\d+\/)?flash\/Player_stream_(custom)?Out\.swf/,
                            'replace':"http://swf.adtchrome.com/17173.out.Live.swf"
                        }
                    },
                    _done: null,
                    get done() {
                        if(!this._done) {
                            this._done = new Array();
                        }
                        return this._done;
                    },
                    addAnimations: function() {
                        var style = document.createElement('style');
                        style.type = 'text/css';
                        style.innerHTML = 'object,embed{\
                       -webkit-animation-duration:.001s;-webkit-animation-name:playerInserted;\
                           -ms-animation-duration:.001s;-ms-animation-name:playerInserted;\
                           -o-animation-duration:.001s;-o-animation-name:playerInserted;\
                           animation-duration:.001s;animation-name:playerInserted;}\
                           @-webkit-keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}\
                           @-ms-keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}\
                           @-o-keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}\
                           @keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}';
                        document.getElementsByTagName('head')[0].appendChild(style);
                    },
                    animationsHandler: function(e) {
                        if(e.animationName === 'playerInserted') {
                            this.replace(e.target);
                        }
                    },
                    replace: function(elem) {
                        if(this.done.indexOf(elem) != -1) return;
                        this.done.push(elem);
                        var player = elem.data || elem.src;
                        if(!player) return;
                        var i, find, replace = false;
                        for(i in this.rules) {
                            find = this.rules[i]['find'];
                            if(find.test(player)) {
                                replace = this.rules[i]['replace'];
                                if('function' === typeof this.rules[i]['preHandle']) {
                                    this.rules[i]['preHandle'].bind(this, elem, find, replace, player)();
                                }else{
                                    this.reallyReplace.bind(this, elem, find, replace)();
                                }
                                break;
                            }
                        }
                    },
                    reallyReplace: function(elem, find, replace) {
                        elem.data && (elem.data = elem.data.replace(find, replace)) || elem.src && ((elem.src = elem.src.replace(find, replace)) && (elem.style.display = 'block'));
                        var b = elem.querySelector("param[name='movie']");
                        this.reloadPlugin(elem);
                    },
                    reloadPlugin: function(elem) {
                        var nextSibling = elem.nextSibling;
                        var parentNode = elem.parentNode;
                        parentNode.removeChild(elem);
                        var newElem = elem.cloneNode(true);
                        this.done.push(newElem);
                        if(nextSibling) {
                            parentNode.insertBefore(newElem, nextSibling);
                        } else {
                            parentNode.appendChild(newElem);
                        }
                    },
                    init: function() {
                        var desc = navigator.mimeTypes['application/x-shockwave-flash'].description.toLowerCase();
                        /*if(desc.indexOf('adobe')>-1){
                         delete this.rules["iqiyi_1"];
                         delete this.rules["iqiyi_2"];
                         }*/
                        var handler = this.animationsHandler.bind(this);
                        document.body.addEventListener('webkitAnimationStart', handler, false);
                        document.body.addEventListener('msAnimationStart', handler, false);
                        document.body.addEventListener('oAnimationStart', handler, false);
                        document.body.addEventListener('animationstart', handler, false);
                        this.addAnimations();
                    }
                };
                new A().init();
            })();
        }
        // 20140730
        (function cnbeta() {
            if (document.URL.indexOf('cnbeta.com') >= 0) {
                var elms = document.body.querySelectorAll("p>embed");
                Array.prototype.forEach.call(elms, function(elm) {
                    elm.style.marginLeft = "0px";
                });
            }
        })();
        // 20150108
        setTimeout(function(){
            if (document.URL.indexOf('www.baidu.com') >= 0) {
                var a = function(){
                    Array.prototype.forEach.call(document.body.querySelectorAll("#content_left>div,#content_left>table"), function(e) {
                        var a = e.getAttribute("style");
                        if(a && /display:(table|block)\s!important/.test(a)){
                            e.removeAttribute("style")
                        }
                    });
                };
                a();
                document.getElementById("su").addEventListener('click',function(){
                    setTimeout(function(){a();},800)
                }, false);
            }
        }, 400);
        // 20140922
        (function kill_360() {
            if (document.URL.indexOf('so.com') >= 0) {
                document.getElementById("e_idea_pp").style.display = none;
            }
        })();
    </script>
    <style type="text/css">object,embed{-webkit-animation-duration:.001s;-webkit-animation-name:playerInserted;                -ms-animation-duration:.001s;-ms-animation-name:playerInserted;                -o-animation-duration:.001s;-o-animation-name:playerInserted;                animation-duration:.001s;animation-name:playerInserted;}                @-webkit-keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}                @-ms-keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}                @-o-keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}                @keyframes playerInserted{from{opacity:0.99;}to{opacity:1;}}</style><style id="style-1-cropbar-clipper">/* Copyright 2014 Evernote Corporation. All rights reserved. */
        .en-markup-crop-options {
            top: 18px !important;
            left: 50% !important;
            margin-left: -100px !important;
            width: 200px !important;
            border: 2px rgba(255,255,255,.38) solid !important;
            border-radius: 4px !important;
        }

        .en-markup-crop-options div div:first-of-type {
            margin-left: 0px !important;
        }
    </style><link type="text/css" rel="stylesheet" href="chrome-extension://pioclpoplcdbaefihamjohnefbikjilc/css/searchhelper.css"></head>
<body scroll="no">

<iframe id="frame3d" name="frame3d" frameborder="0" width="100%" scrolling="auto" style="margin-top: -4px; height: 985px;" onload="this.style.height=document.body.clientHeight" height="100%" src="http://www.haosou.com/s?ie=utf-8&amp;shb=1&amp;src=360sou_newhome&amp;q="></iframe>

@if(isset($posterList[0]) && $posterList[0])
<div style="height:450px;width:100px;margin:0 auto;position:absolute;top:80px;left:70%;"><a href="{{$posterList[0]['url']}}" target="_blank"><img src="{{$posterList[0]['image']}}"  align="left" border="0" height="450" width="100"></a></div>
@endif

@if(isset($posterList[1]) && $posterList[1])
<div style="width:1000px;margin:0 auto;position:absolute;bottom:0;left:0;"><a href="{{$posterList[1]['url']}}" target="_blank"><img src="{{$posterList[1]['image']}}" align="left" border="0" height="90" width="1000"></a></div>
@endif

</body><div></div></html>