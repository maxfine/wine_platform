@yield('header')
<div class="row border-bottom">
    <nav class="navbar navbar-fixed-top" style="margin-bottom: 0" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">JIU.ZNYES.COM</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">首页</a></li>
                    <li ><a href="{{ url('/') }}">功能与价格</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/member') }}">登录</a></li>
                        <li><a href="{{ url('/auth/register') }}">注册</a></li>
                    @elseif(\Entrust::hasRole('admin'))
                        {{-- 管理员 --}}
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/admin') }}">后台管理</a></li>
                                <li><a href="{{ url('/auth/logout') }}">退出登陆</a></li>
                            </ul>
                        </li>
                    @else
                        {{-- 会员 --}}
                        <li><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out"></i> 退出登录</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>
