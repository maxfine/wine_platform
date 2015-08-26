<!-- side_left -->
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{ asset('img/profile_small.jpg') }}" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Beaut-zihan</strong>
                             </span> <span class="text-muted text-xs block">超级管理员 <b class="caret"></b></span> </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="form_avatar.html">修改头像</a>
                        </li>
                        <li><a href="profile.html">个人资料</a>
                        </li>
                        <li><a href="contacts.html">联系我们</a>
                        </li>
                        <li><a href="mailbox.html">信箱</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ URL('auth/logout') }}">安全退出</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">
                    ZNYES
                </div>
            </li>

            @foreach($backNavs as $item)
                <li class="treeview">
                    <a href="javascript:void(0);"><i class="fa fa-{{$item['icon']}}"></i> <span class="nav-label">{{$item['title']}}</span> <span class="fa arrow"></span></a>
                    @if($item['childs'] !== false)
                    <ul class="nav nav-second-level">
                        @foreach($item['childs'] as $child)
                            {!! HTML::menu_active($child['slug'], $child['title']) !!}
                        @endforeach
                    </ul>
                    @endif
                </li>
            @endforeach
        </ul>

    </div>
</nav>

<!-- /side_left -->