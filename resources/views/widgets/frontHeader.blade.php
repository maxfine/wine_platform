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
                <span class="change-skin">
                    <a href="Javascript:;" title="点击切换网站显示风格" class="change-skin-now" id="6dbd63" style="background-color:#6dbd63;">&nbsp;</a>
                    <a href="Javascript:;" title="点击切换网站显示风格" class="change-skin-now" id="28a5a8" style="background-color:#28a5a8;">&nbsp;</a>
                    <a href="Javascript:;" title="点击切换网站显示风格" class="change-skin-now" id="e96b56" style="background-color:#e96b56;">&nbsp;</a>
                    <a href="Javascript:;" title="点击切换网站显示风格" class="change-skin-now" id="47c9af" style="background-color:#47c9af;">&nbsp;</a>
                    <a href="Javascript:;" title="点击切换网站显示风格" class="change-skin-now" id="4c0066" style="background-color:#4C0066;">&nbsp;</a>
                    <a href="Javascript:;" title="点击切换网站显示风格" class="change-skin-now" id="d6c05d" style="background-color:#d6c05d;">&nbsp;</a>
                    <a href="Javascript:;" title="点击切换网站显示风格" class="change-skin-now" id="467da2" style="background-color:#467da2;">&nbsp;</a>
                </span>
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


