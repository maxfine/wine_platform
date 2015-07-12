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
                    H+
                </div>

            </li>
            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-th-large"></i> <span class="nav-label">控制面板</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('admin') }}"><i class="fa fa-circle-o"></i> 概述</a></li>
                    <li><a href="{{ route('admin') }}"><i class="fa fa-circle-o"></i> 个人资料</a></li>
                    <li><a href="{{ route('admin') }}"><i class="fa fa-circle-o"></i> 重建缓存</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="javascript:void(0);"><i class="fa fa-edit"></i> <span class="nav-label">内容管理</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ URL('admin/articles') }}"><i class="fa fa-circle-o"></i> 文章列表</a></li>
                    <li><a href="{{ URL('admin/article/cats') }}"><i class="fa fa-circle-o"></i> 文章分类</a></li>
                    <li><a href="{{ URL('admin/pages') }}"><i class="fa fa-circle-o"></i> 单页列表</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="{{ URL('admin/pages') }}"><i class="fa fa-columns"></i> <span class="nav-label">布局</span><span class="label label-danger pull-right">2.0</span></a>
            </li>

            <li class="treeview">
                <a href="index.html#"><i class="fa fa-sitemap"></i> <span class="nav-label">菜单 </span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="index.html#">三级菜单 <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="index.html#">三级菜单 01</a>
                            </li>
                            <li>
                                <a href="index.html#">三级菜单 01</a>
                            </li>
                            <li>
                                <a href="index.html#">三级菜单 01</a>
                            </li>

                        </ul>
                    </li>
                    <li><a href="index.html#">二级菜单</a>
                    </li>
                    <li>
                        <a href="index.html#">二级菜单</a>
                    </li>
                    <li>
                        <a href="index.html#">二级菜单</a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
<!-- /side_left -->