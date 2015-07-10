<ul>    
    {{~it.list:notes:index}}
    <li class="clearfix othercode-item" >
      <div class="otherscode l">
        <a class="othercode-avator" href="{{=tplDef.url_space_u}}/uid/{{=notes.uid}}" target="_blank">
          <img src="{{=notes.portrait}}" width="40" height="40">
        </a>
        <a class="othercode-nick" href="{{=tplDef.url_space_u}}/uid/{{=notes.uid}}" target="_blank">
          {{=notes.nickname}}:
        </a>
        <a href="javascript:void(0);" class="otherscode-code" data-id="{{=notes.id}}"></a>
        {{? +notes.ontop>0}}
        <span class="othercode-nice">优秀代码</span>
        {{?}}
      </div>
      <div class="otherscode-list-bottom r"> 
        <span title="{{=notes.create_time}}" class="otherscode-time">{{=notes.create_time}}</span>
        {{?notes.has_support>0}} 
          <a title="赞" href="javascript:;" class="list-praise on" data-id="{{=notes.id}}"><span class="icon icon_good on"></span>
        {{??}}
          <a title="赞" href="javascript:;" class="js-otherscode-praise list-praise " data-id="{{=notes.id}}"><span class="icon icon_good"></span>
        {{?}}
        <em>{{=notes.support}}</em></a>
      </div>
    </li>
    {{~}}
</ul>