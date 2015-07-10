{{~ it.list :v:index}}
    <div class="wenda-listcon clearfix">
        <div class="headslider fl">
            <a href="{{=tplDef.url_space_u}}/uid/{{=v.uid}}" class="wenda-head" target="_blank" title="{{=v.nickname}}">
                <img src="{{=v.pic}}" alt="{{=v.nickname}}" width="40">
            </a>
            <a href="{{=tplDef.url_space_u}}/uid/{{=v.uid}}" target="_blank" title="{{=v.nickname}}" class="wenda-nickname">{{=v.nickname}}</a>
        </div>
        <div class="wendaslider fl">
            <a href="{{=tplDef.url_course_qadetail}}/{{=v.id}}" target="_blank" class="replynumber {{? v.answers == 0}}noanswernum {{??}}hasanswernum{{?}}">
                <div class="ys">
                    <div class="number padAjust">
                        <b class="numShow">{{=v.answers}}</b>
                    </div>
                    <div class="number">回答</div>
                </div>
                <div class="browsenum">
                    <div class="number padAjust">
                        <b class="numShow">{{=v.view_num}}</b>
                    </div>
                    <div class="number">浏览</div>
                </div>
            </a>
            <h2 class="wendaquetitle">
                {{? v.finished > 0}}
                    <i class="isfinish"></i>
                {{??}}
                    <i class="nofinish"></i>
                {{?}}
                <div class="wendatitlecon">
                    {{? v.istop == 1}}
                        <span class="istop fl">[置顶]</span>
                    {{?}}
                    <a href="{{=tplDef.url_course_qadetail}}/{{=v.id}}" target="_blank" class="wendatitle">
                    {{? !!v.title}}
                        {{=v.title}}
                    {{??}}
                        {{=v.description.replace(/<[^>]*?>/g,"").substr(0,130)}}
                    {{?}}
                    </a>
               </div>
            </h2>
            {{ var typeText={1:'已采纳的回答',2:'老师的回答',3:'最赞回答',4:'最新回答'},typeClass={1:'adopt',2:'adopt',3:'praise',4:'praise'}; }}
            <div class="replycont clearfix">
                <i class="replyicon fl"></i>
                {{? v.reply.type < 5}}
                    <div class="fl replydes">
                      <span class="replysign {{=typeClass[v.reply.type]}}">[{{=typeText[v.reply.type]}}]</span>
                      <a href="{{=tplDef.url_space_u}}/uid/{{=v.reply.uid}}" target="_blank" title="{{=v.reply.reply_nickname}}" class="replyuserhead"><img src="{{=v.reply.pic}}" alt="{{=v.reply.reply_nickname}}" width="20"> </a>
                      <a href="{{=tplDef.url_space_u}}/uid/{{=v.reply.uid}}" target="_blank" title="{{=v.reply.reply_nickname}}" class="nickname">{{=v.reply.reply_nickname}}: </a>
                      <span class="replydet">{{=v.reply.description}}</span>
                    </div>
                {{?? v.reply.type == 5}}
                    <div class="fl replydes">
                       <span class="replydet">嗯～～，这个提问大家都在考虑......</span>
                    </div>
                {{?}}
            </div>
            <div class="replymegfooter">
                <div class="wenda-time">
                    <em>时间：{{=v.create_time}}</em>
                </div>
            </div>
        </div>
     </div>
{{~}}
