@extends('layout._base')

@section('hacker_header')
    <!--
    modified by max_fine(max_fine@qq.com)
    -->
@stop

@section('title') 会员系统 - 老酒交易平台 @stop

@section('meta')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
@stop

@section('head_css')
    <link href="{{ asset('css/bootstrap.min.css?v=3.4.0') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css?v=4.3.0') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front-style.css?v=2.2.0') }}" rel="stylesheet">
@stop

@section('head_js')
    <!--[if lt IE 8]>
    <script>
        alert('H+已不支持IE6-8，请使用谷歌、火狐等浏览器\n或360、QQ等国产浏览器的极速模式浏览本页面！');
    </script>
    <![endif]-->

    <script type="text/javascript">
        var BASE_URL = "{{ \Config::get('app')['url'] }}";
    </script>
    @parent
@stop

@section('body_attr') class="fixed-sidebar full-height-layout gray-bg" style="padding-top: 70px;"@stop

@section('beforeBody')
    <!--侦测是否启用JavaScript脚本-->
    <noscript>
        <style type="text/css">
            .noscript{ width:100%;height:100%;overflow:hidden;background:#000;color:#fff;position:absolute;z-index:99999999; background-color:#000;opacity:1.0;filter:alpha(opacity=100);margin:0 auto;top:0;left:0;}
            .noscript h1{font-size:36px;margin-top:50px;text-align:center;line-height:40px;}
            html {overflow-x:hidden;overflow-y:hidden;}/*禁止出现滚动条*/
        </style>
        <div class="noscript">
            <h1>
                您的浏览器不支持JavaScript，请启用后重试！
            </h1>
        </div>
    </noscript>

    <!--wrapper start-->
    <div id="wrapper">
@stop

        @section('body')

            @include('widgets.frontHeader')

            @include('widgets.member-sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div id="page-wrapper" class="gray-bg dashbard-1">
                <!-- Content Header (Page header) -->
                @section('content-header')
                @show{{-- 内容导航头部 --}}

                <!-- Main content -->
                @section('content')
                @show{{-- 内容主体区域 --}}
                <!-- /content -->

                @include('widgets.frontFooter')
            </div><!-- /.content-wrapper -->
        @stop

    @section('afterBody')
    </div><!-- ./wrapper -->

    <!-- 全局js -->
    <script src="{{ asset('http://fex.baidu.com//webuploader/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js?v=3.4.0') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/layer/layer.min.js') }}"></script>
    <script src="{{ asset('js/jquery.cookie.js') }}"></script>

    <!-- 自定义js -->
    <script src="{{ asset('js/common.js?v=3.0.0') }}"></script>

    <!-- 第三方插件 -->
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@section('extraPlugin')
@show{{-- 引入额外依赖JS插件 --}}

<script type="text/javascript">
    $(document).ready(function(){
        //$('ul.nav-second-level>li').find('a[href="@{{ cur_nav(Route::currentRouteName()) }}"]').closest('li').addClass('active').parent('ul').addClass('in');  //二级链接高亮
        //$('ul.nav-second-level>li').find('a[href="@{{ cur_nav(Route::currentRouteName()) }}"]').closest('li.treeview').addClass('active').children('ul').addClass('in');  //一级栏目[含二级链接]高亮
        //$('ul#side-menu>li').find('a[href="@{{ cur_nav(Route::currentRouteName()) }}"]').closest('li').addClass('active');  //一级栏目[不含二级链接]高亮

        @section('filledScript')
        @show{{-- 在document ready 里面填充一些JS代码 --}}
    });
</script>

@section('extraSection')
@show{{-- 补充额外的一些东东，不一定是JS，可能是HTML --}}
@stop


@section('hacker_footer')
    <!--
    ______                            _              _                                     _
    | ___ \                          | |            | |                                   | |
    | |_/ /___ __      __ ___  _ __  | |__   _   _  | |      __ _  _ __  __ _ __   __ ___ | |
    |  __// _ \\ \ /\ / // _ \| '__| | '_ \ | | | | | |     / _` || '__|/ _` |\ \ / // _ \| |
    | |  | (_) |\ V  V /|  __/| |    | |_) || |_| | | |____| (_| || |  | (_| | \ V /|  __/| |
    \_|   \___/  \_/\_/  \___||_|    |_.__/  \__, | \_____/ \__,_||_|   \__,_|  \_/  \___||_|
                                              __/ |
                                             |___/
    -->
@stop