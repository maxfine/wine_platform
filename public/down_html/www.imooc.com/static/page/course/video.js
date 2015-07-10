define(function(require, exports, module){
	require('jwplayer');
    var animateMp = require('./common/animate-achievement');
    var store=require('store');
	var commonInterface=require("/static/page/course/common/course_detail_common.js");

	$.getJSON("/course/ajaxmediainfo/?mid="+pageInfo.mid+"&mode=flash",function(data){
		mediaData=data.data.result;
		initPlayer();
	});

	if(typeof continueTime != 'number'){
		continueTime=0;
        var sv=store.get("_vt");
        if(sv&&sv[pageInfo.mid]){
            continueTime=sv[pageInfo.mid].st||0;
        }
	}

    $(window).on("beforeunload",function(){
        var vt=store.get("_vt")||{},
            it=vt[pageInfo.mid],
            state=thePlayer.getState();
        if(state=="IDLE"){
            delete vt[pageInfo.mid];
            store.set("_vt",vt);
            return ;
        }
        if(it){
            it.t=new Date().getTime();
            it.st=thePlayer.getPosition();
            store.set("_vt",vt);
        }
        else{
            it={
                t:new Date().getTime(),
                st:thePlayer.getPosition()
            }
            ck();
            vt[pageInfo.mid]=it;
            store.set("_vt",vt);
        }
        function ck(){ //check length<10 ,delete overflowed;
            var k,tk,i=0,tt=new Date().getTime();
            for(k in vt){
                i++;
                if(vt[k].t<tt){
                    tt=vt[k].t;
                    tk=k;
                }
            }
            if(i>=10){
                delete vt[tk];
                ck();
            }
        }
    });
	var sentLearnTime=(function(){
		if(!OP_CONFIG.userInfo){
			return ;
		}
	 	var _params={},
	 		lastTime=0,
	 		startTime=new Date().getTime();
		var fn;
	    _params.mid=pageInfo.mid;

	    window.setInterval(fn=function(){
			var overTime,
				stayTime;
			if(typeof(thePlayer)!='object') return //no video no time;
			overTime=new Date().getTime();
			stayTime=parseInt(overTime-startTime)/1000;

			_params.time=stayTime-lastTime;
			_params.learn_time =thePlayer.getPosition();

			$.ajax({
				url:'/course/ajaxmediauser/',
				data:_params,
				type:"POST",
				dataType:'json',
				success:function(data){
					if(data.result== '0'){
						lastTime=stayTime;
                        var chapterMp = data.data.media;
                        var courseMp = data.data.course;
                        var data = [];
                        chapterMp && data.push({mp: chapterMp.mp.point, desc: chapterMp.mp.desc});
                        courseMp && data.push({mp: courseMp.mp.point, desc: courseMp.mp.desc});
                        animateMp(data);
					}
				}
			});
		},60000);

		window.onbeforeunload=function(){
			var overTime,
				stayTime;
			if(typeof(thePlayer)!='object') return //no video no time;
			overTime=new Date().getTime();
			stayTime=parseInt(overTime-startTime)/1000;

			_params.time=stayTime-lastTime;
			_params.learn_time =thePlayer.getPosition();

			$.ajax({
				url:'/course/ajaxmediauser/',
				data:_params,
				type:"POST",
				async:false,
				dataType:'json',
				success:function(data){
					if(data.result=='0'){
						lastTime=stayTime;
					}
				}
			});
		}
		return fn;
	})();

	//总是以flash的方式开始调用
    function initPlayer(){
        thePlayer = jwplayer('video-box').setup({
            width:1200,
            height:530,
            videoTitile: videoTitle,
			primary: "flash",
            autostart:false,
            startparam: "start",
            autochange:true,
            playlist: [{
                //image: "JW.jpg",
                sources: [{
                   file: mediaData.mpath[2],
				   // file: "http://10.96.141.77/e1df8c31-3ab8-4efb-9d48-e5134a59dcca/Y_dest_1.mp4",
                    label: "普清",
                    "default": true
                },{
                    file: mediaData.mpath[1],
                    label: "高清"
                },{
                    file: mediaData.mpath[0],
                    label: "超清"
                }]
            }],

            events: {
                onReady: function() {//
                    if(OP_CONFIG.userInfo){
                        thePlayer.seek(continueTime);
                    }
                },
                onComplete: function(){
                    $('#J_NextBox').removeClass('hide');
                    sentLearnTime();
                },
    		    onBuffer:function(callback){//缓冲状态，缓冲图标显示

					//playserWaitTime=new Date().getTime();

					//key=radKey(10)+playserWaitTime;
					//sendVideoTestData(2,0,"",playserWaitTime,0);

				},
				onPlay:function(callback){//开始播放－缓冲结束

					//if(callback.oldstate=="PAUSED" ){
						//return;
					//}
					//var bufferTme=new Date().getTime()-playserWaitTime;
					//sendVideoTestData(1,bufferTme,"",new Date().getTime(),1);

				},
				 onQualityChange :function(callback){
					//console.log("onQualichange-----");
				},

				onError:function (callback){
					//loadVideo(callback.message);
					sendVideoTestData("","",callback.message,"","");
				}
            }
        })
    }


 //视频不能播放出错后flash回调
window.videoErrorMsg=videoErrorMsg;
function videoErrorMsg(msg){
	//var bufferTme=new Date().getTime()-playserWaitTime;
	//sendVideoTestData(0,bufferTme,msg,new Date().getTime(),1);
}



//截图后flash回调
window.screenReceive=screenReceive;
function screenReceive(data){
	if(typeof data=="string"){

		data=$.parseJSON(data);
	}
	if(data.result==0){
		shot.screenShotFlashBack(data);
	}
	else{
		alert(data.msg||"错误，请稍后重试");
	}
	//console.log(url,typeof url)
}

$.each("qa,note".split(","),function(k,v){
   	commonInterface.remote[v].extendMethod("reset",function(){
   		shot.reset(".js-shot-video[data-type='"+v+"']");
   	});
});

var shot={
	screenShot:function(el){
		if(thePlayer.getState()=="IDLE"){
			alert('请在视频播放时截图')
			return ;
		}
	    if(!thePlayer.getState()){
			alert('请在视频播放时截图')
			return ;
		}
	    if(thePlayer.getState()=="PLAYING"){
			thePlayer.pause();
		}
		/*
		try{
			thePlayer.screenShot();
		}
		catch(e){
			alert("您当前使用的html5播放器暂不支持视频截图，请下载flash播放器");
		}
		*/
		//$('.shot-btn').addClass('hide');
		var $el=$(el),
			time=parseInt(thePlayer.getPosition(),10);
			//time=(thePlayer.getPosition()-0.05);
			var shotTime=Math.round (thePlayer.getPosition());
		var matches;
		matches = thePlayer.getPlaylistItem().file.match(/\/([^\/]*?)\/[^\/]+?$/)[1];
		this.el=el;
		$el.next().find(".shot-time").text(this.formatSecond(time));
		$el.hide().next().show();
		commonInterface.remote[$el.attr("data-type")].set({picture_time:time});
		/*
			$.ajax({
					url:"http://upload.mukewang.com/i.php?file="+videoId+"&seek="+time,
					type:"GET",
					
					success:function(data){
						screenReceive(data);
					}	
				});
				//
		*/	//DES(Imooc*#12@#/时间/视频名称/seek/)
		//http://www-yuanxch.imooc.com/course/ajaxextractimage?file=xiaoship&seek=2&callback=abc　视频截图．新的调用方式
		//var sendStr=des('Imooc*#12@#&time='+ new Date()+ '&file=' + matches + '&seek=' + shotTime );
		
		    $.getJSON('/course/ajaxextractimage?file=' + matches + '&seek=' + shotTime + '&r=' + (+new Date()) + '&callback=?', function(data) {
				//console.log(data);	
				screenReceive(data);
			});
	},
	formatSecond:function(sec){
        var result = _format(parseInt(sec/60))+":"+_format(sec%60);
        function _format(min){
            return min < 10 ? '0' + min: min;
        }
        return result;
    },
    reset:function(el,fromEl){
    	var $el=$(el),$next;
    	this.el=null;
    	($next=$el.show().next()).hide();
    	$next.find("img").attr("src","");
   		$next.find(".shot-time").text("");
    	fromEl&&commonInterface.remote[$el.attr("data-type")].reset();
    },
    screenShotFlashBack:function(data){
    	if(!this.el) return ;
		//console.log(data)
		//console.log(data.data)
    	$(this.el).next().find("img").attr("src",data.data);
    	commonInterface.remote[$(this.el).attr("data-type")].set("picture_url",data.data);
    }
}

$(".js-shot-video").click(function(){
	shot.screenShot(this);
});
$(".js-close-vshot").click(function(){
	shot.reset($(this).parent().prev(),1);
});



});
