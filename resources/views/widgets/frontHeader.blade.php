@yield('header')
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">JIU.ZNYES.COM</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            @if (Auth::guest())
                <ul class="nav navbar-nav navbar-right login">
                    <li><a href="{{ url('/member') }}">登陆</a></li>
                    <li class="visible-lg"><a href="">/</a></li>
                    <li><a href="{{ url('/auth/register') }}">注册</a></li>
                </ul>
            @elseif(\Entrust::hasRole('admin'))
                <ul class="nav navbar-nav navbar-right login">
                    <li><a href="{{ url('/admin') }}">{{ Auth::user()->name }}</a></li>
                    <li class="visible-lg"><a href="">/</a></li>
                    <li><a href="{{ url('/auth/logout') }}">退出登录</a></li>
                </ul>
            @else
                <ul class="nav navbar-nav navbar-right login">
                    <li><a href="{{ url('/member') }}">{{ Auth::user()->name }}</a></li>
                    <li class="visible-lg"><a href="">/</a></li>
                    <li><a href="{{ url('/auth/logout') }}">退出登录</a></li>
                </ul>
            @endif
            <ul class="nav navbar-nav navbar-right q-nav">
                <li class='active'><a href="{{ url('/') }}">首页</a></li>
                <li ><a href="{{ url('/') }}">功能与价格</a></li>
            </ul>

        </div>

    </div>
</nav>
