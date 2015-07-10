define(['jquery'],function(require, exports, module){
    //var $ = require('jquery');

    var setting = {
            targetTo: '#js-user-avatar',
            targetNum: '#js-user-mp',
            targetFrom: '#studyMain'
        },
        html = '<div class="animate-mp"> \
            <p class="mp">经验<span class="num">+${mp}</span></p> \
            <p class="desc">${desc}</p> \
        </div>';

    function animate(data) {
        var $from,
            fromOffset,
            fromRect = {},
            $to,
            $toOffset,
            toRect = {},
            $mp,
            dataItem;
        if(Object.prototype.toString.call(data) !== '[object Array]') {
            data=[data];
        }

        if(!data.length) return ;
        dataItem=data.shift();

        $from = $(setting.targetFrom);
        fromOffset=$from.offset();
        fromRect.width = $from.width();
        fromRect.height = $from.height();

        $to = $(setting.targetTo);
        toOffset = $to.offset();
        toRect.width = $to.outerWidth();
        toRect.height = $to.outerHeight();

        $mp = $(html.replace(/\$\{(\w+?)\}/g, function(s,m) {
            return dataItem[m]||m;
        }));

        $mp.appendTo('body')
        .css({
            left: fromOffset.left + fromRect.width / 2 -70, //animate-map has 140 width in css
            top: fromOffset.top + fromRect.height / 2 -30  //animate-map has 50 height in css
        })
        .fadeIn()
        .delay(1500)
        .animate({
            left: toOffset.left + toRect.width - 140,
            top: toOffset.top + toRect.height - 60,
            opacity: 0.1
        }, function() {
            $mp.remove();
            $(setting.targetNum).text(parseInt($(setting.targetNum).text())+dataItem.mp);
            if(data.length) {
                animate(data);
            }
        });
    }

    return function(data,opt){
        $.extend(setting,opt||{});
        if(data.length) {
            animate(data);
        }
    }
});
