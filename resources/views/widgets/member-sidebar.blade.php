<!--左侧导航开始-->
<nav class="navbar-default navbar-static-side" role="navigation" data-control="sidenav-tree" data-search-input="#settings-search-input">
    <div class="sidebar-collapse">
    <ul class="nav" id="side-menu">
        <li class="nav-header">
            <div class="dropdown profile-element">
                <span><img alt="image" class="img-circle" width="64" height="64" src="{{ URL('img/a4.jpg') }}" /></span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs"><strong class="font-bold">Beaut-zihan</strong></span>
                                    <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                                </span>
                </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                    <li><a class="J_menuItem" href="javascript:;">修改头像</a>
                    </li>
                    <li><a class="J_menuItem" href="javascript:;">个人资料</a>
                    </li>
                    <li><a class="J_menuItem" href="javascript:;">联系我们</a>
                    </li>
                    <li><a class="J_menuItem" href="javascrip:;">信箱</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="">安全退出</a>
                    </li>
                </ul>
            </div>
            <div class="logo-element">ZNYES</div>
        </li>


       @if($tree)
            {!! $tree->getTreeView(1) !!}
       @endif
        
     </ul>
    </div>
</nav>
<!--左侧导航结束-->

<!--
//todo教程
<span class="label label-warning pull-right">16</span>
-->