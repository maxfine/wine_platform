<!--左侧导航开始-->
<nav class="navbar-default navbar-static-side" role="navigation" data-control="sidenav-tree" data-search-input="#settings-search-input">
    <div class="sidebar-collapse">
    <ul class="nav" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">
                <span><img alt="image" class="img-circle" src="{{ URL('img/profile_small.jpg') }}" /></span>
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
            <div class="logo-element">ZNYES</div>
        </li>


       {!! $tree->getTreeView(1) !!}
        
     </ul>
    </div>
</nav>
<!--左侧导航结束-->

<!--
//todo教程
<span class="label label-warning pull-right">16</span>
-->