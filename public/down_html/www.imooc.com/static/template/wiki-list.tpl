 <ul>    
    {{~ it.list:wiki:index}}
    <li>
    <div class="wikilist_headpic">
    <a href="{{? wiki.uid == OP_CONFIG.userInfo.uid}}{{=tplDef.url_space_index}}{{??}}{{=tplDef.url_space_u}}/uid/{{=wiki.uid}}{{?}}" target="_blank"><img width="40" height="40" src="{{=wiki.head}}" title="{{=wiki.nickname}}" /></a>
    </div>
    <div class="wikilist_content">
       <div class="u_name"> <a href="{{? wiki.uid == OP_CONFIG.userInfo.uid}}{{=tplDef.url_space_index}}{{??}}{{=tplDef.url_space_u}}/uid/{{=wiki.uid}}{{?}}" target="_blank">{{=wiki.nickname}}</a> </div>
    <h1> <a target="_blank" href="/wiki/view?pid={{=wiki.p_id}}">{{=wiki.title}}</a></h1>
    <div>{{=wiki.content}}</div> 
    <div class="wiki-time">
        <span>时间: {{=wiki.updatetime}}</span>
    </div>
    </div>
    </li>
    {{~}}
</ul>