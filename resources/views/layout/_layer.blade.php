@extends('layout._base')

@section('title') {{ isset($title) ? $title : '前台' }} - {{ Cache::get('website_title','老酒交易平台') }} @stop

@section('meta')
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
@stop

@section('head_css')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css?v=4.3.0') }}" rel="stylesheet">

    <!-- Morris -->
    <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front-style.css?v=2.2.0') }}" rel="stylesheet">
@stop

@section('head_js')
    <!--这里使用旧版jQuery-->
    <script type="text/javascript" src="{{ asset('plugins/jQuery/jQuery-1.8.3.min.js') }}"></script>
@stop

@section('head_style')
    <style>
        body{background-color: rgba(255, 255, 255, 0.07);}
        .znyes_layer{padding: 20px 0 0 10px;}
    </style>
@show{{-- head区域内联css样式表 --}}

@section('body')
    <div class="znyes_layer">
        @section('mainLayerCon')
        @show{{-- layer表单页面主体内容 --}}
    </div>
@stop

@section('afterBody')
@parent
    @section('endChosen')
    @show{{-- chosen下拉选择表单 --}}
    @section('endLayerJS')
    @show{{-- layer响应部分事件JS --}}
@stop
