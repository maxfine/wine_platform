<!--左侧导航开始-->
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="img/profile_small.jpg" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs"><strong class="font-bold">Beaut-zihan</strong></span>
                                    <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                                </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="J_menuItem" href="form_avatar.html">修改头像</a>
                        </li>
                        <li><a class="J_menuItem" href="profile.html">个人资料</a>
                        </li>
                        <li><a class="J_menuItem" href="contacts.html">联系我们</a>
                        </li>
                        <li><a class="J_menuItem" href="mailbox.html">信箱</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html">安全退出</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">H+
                </div>
            </li>

            @foreach($backNavs as $data)
            <li>
                <a href="javascript:void(0);">
                    <span class="fa arrow"></span>
                    <i class="fa fa-{{$data['icon']}}"></i>
                    <span class="nav-label">{{$data['title']}}</span>
                </a>
                @if($data['childs'] !== false)
                <ul class="nav nav-second-level">
                    @foreach($data['childs'] as $item)
                        @if(isset($item['childs']) && $item['childs'])
                            <li>
                                <a href="javascript:;">
                                    <span class="fa arrow"></span>
                                    <span class="nav-label">{{ $item['title'] }}</span>
                                </a>
                                <ul class="nav nav-third-level">
                                    @foreach($item['childs'] as $row)
                                        <li><a class="J_menuItem" href="{{ URL($row['slug']) }}">{{ $row['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a class="J_menuItem" href="{{ URL($item['slug']) }}">{{ $item['title'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</nav>
<!--左侧导航结束-->

<!--
//教程
<span class="label label-warning pull-right">16</span>
-->