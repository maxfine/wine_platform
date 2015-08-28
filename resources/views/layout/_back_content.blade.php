@extends('layout._base')

@section('hacker_header')
<!--
    modified by max_fine(max_fine@qq.com)
-->
@stop

@section('title') 后台 - 老酒交易平台 @stop

@section('meta')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="renderer" content="webkit">
@stop

@section('head_css')
    <link href="{{ asset('css/bootstrap.min.css?v=3.4.0') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css?v=4.3.0') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css?v=3.0.0') }}" rel="stylesheet">
@stop

@section('head_js')
    <script type="text/javascript">
        var BASE_URL = "{{ \Config::get('app')['url'] }}";
        var ADMIN_HOME = BASE_URL + '/' + 'admin';
    </script>
@parent
@stop

@section('body_attr') class="gray-bg"@stop

@section('beforeBody')
@stop

@section('body')
          <!-- Content Header (Page header) -->
              @section('content-header')
              @show{{-- 内容导航头部 --}}

          <!-- Main content -->
              @section('content')
              @show{{-- 内容主体区域 --}}
          <!-- /content -->
@stop

@section('afterBody')
    <!-- 全局js -->
    <script src="{{ asset('http://fex.baidu.com//webuploader/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js?v=3.4.0') }}"></script>
    <script src="{{ asset('js/plugins/layer/layer.min.js') }}"></script>

    <!-- 自定义js -->
    <script src="{{ asset('js/content.js') }}"></script>

    <!-- 第三方插件 -->
    @section('extraPlugin')
    @show{{-- 引入额外依赖JS插件 --}}

    <script type="text/javascript">
      $(document).ready(function(){
          @section('filledScript')
          @show{{-- 在document ready 里面填充一些JS代码 --}}
      });
    </script>

    @section('extraSection')
    @show{{-- 补充额外的一些东东，不一定是JS，可能是HTML --}}
@stop


@section('hacker_footer')
@stop
