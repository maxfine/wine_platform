@extends('layout._back_content')

@section('content-header')
@parent
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-sm-12">
      <blockquote class="text-warning" style="font-size:14px">
          杭州正言科技高端设计师,专业的杭州网站建设公司,营销型定制网站建设,手机网站建设,网站均拥有精准SEO后台
          <br>
          网络整合营销,seo优化整体方案企业首选:400-666-2574
          <br>
          老酒交易平台
          <br>…………
          <h4 class="text-danger">{{ Config::get('app.url') }}</h4>
      </blockquote>
    </div>
</div>
@endsection


@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
                        <div class="col-md-12">
                        <div class="panel panel-default">
                        <div class="panel-heading">单页</div>

                        <!-- pages -->
                        <div class="panel-body">

                        <a href="{{ URL('admin/pages/create') }}" class="btn btn-lg btn-primary">新增</a>

                        @foreach ($pages as $page)
                        <hr>
                        <div class="page">
                        <h4>{{ $page->title }}</h4>
                        <div class="content">
                        <p>
                        {{ $page->body }}
                        </p>
                        </div>
                        </div>
                        <a href="{{ URL('admin/pages/'.$page->id.'/edit') }}" class="btn btn-success">编辑</a>


                        <form action="{{ URL('admin/pages/'.$page->id) }}" method="POST" style="display: inline;">
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">删除</button>
                        </form>
                        <a href="{{ URL('admin/comments/list/'.$page->id.'/'.$page::commentType) }}" class="btn btn-success">评论列表</a>
                        <a href="{{ URL('admin/comments/create/'.$page->id.'/'.$page::commentType()) }}" class="btn btn-success">添加评论</a>
                        @endforeach

                        </div>

                        </div>
                        </div>
                        </div>

    <div class="row">
                        <div class="col-md-12">
                        <div class="panel panel-default">
                        <div class="panel-heading">文章栏目</div>
                        <!-- articles -->
                        <div class="panel-body">

                        <a href="{{ URL('admin/article/cats/create') }}" class="btn btn-lg btn-primary">新增栏目</a>

                        @foreach ($articleCats as $articleCat)
                        <hr>
                        <div class="page">
                        <h4>{{ $articleCat->cat_name }}</h4>
                        <div class="content">
                        <p>
                        {{ $articleCat->cat_brief }}
                        </p>
                        </div>
                        </div>
                        <a href="{{ URL('admin/article/cats/'.$articleCat->id.'/edit') }}" class="btn btn-success">编辑</a>

                        <form action="{{ URL('admin/article/cats/'.$articleCat->id) }}" method="POST" style="display: inline;">
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">删除</button>
                        </form>
                        <a href="{{ URL('admin/articles/'.$articleCat->id.'/list') }}" class="btn btn-success">文章列表</a>
                        @endforeach

                        </div>

                        </div>
                        </div>
                        </div>

    <div class="row">
                        <div class="col-md-12">
                        <div class="panel panel-default">
                        <div class="panel-heading">文章</div>
                        <!-- articles -->
                        <div class="panel-body">

                        <a href="{{ URL('admin/articles/create') }}" class="btn btn-lg btn-primary">新增文章</a>

                        @foreach ($articles as $article)
                        <hr>
                        <div class="page">
                        <h4>{{ $article->title }}</h4>
                        <div class="content">
                        <p>
                        {{ $article->body }}
                        </p>
                        </div>
                        </div>
                        <a href="{{ URL('admin/articles/'.$article->id.'/edit') }}" class="btn btn-success">编辑</a>

                        <form action="{{ URL('admin/articles/'.$article->id) }}" method="POST" style="display: inline;">
                        <input name="_method" type="hidden" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">删除</button>
                        </form>
                        <a href="{{ URL('admin/comments/'.$article->id.'/'.$article::commentType.'/list') }}" class="btn btn-success">评论列表</a>
                        <a href="{{ URL('admin/comments/'.$article->id.'/'.$article::commentType().'/create') }}" class="btn btn-success">添加评论</a>
                        @endforeach

                        </div>

                        </div>
                        </div>
                        </div>

</div>
@stop

@section('extraPlugin')
    <script id="welcome-template" type="text/x-handlebars-template">
        <div class="border-bottom white-bg page-heading clearfix">
            <h2>更新日志：</h2>
            <div>今天是情人节，H+终于跨到了v3.0，就是是情人节礼物吧，感谢你们的不离不弃，一路相伴！</div>
            <div class="pull-right">——Beau-zihan / 2015.8.20</div>
        </div>
        <div class="m">
            <div class="alert alert-warning alert-dismissable m-b-sm">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                同时这也是一个示例，演示了如何从iframe中弹出一个覆盖父页面的层。
            </div>
            <div class="tabs-container">
                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#layouts"><i class="fa fa-columns"></i> 布局
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#new"><i class="fa fa-plus-square"></i> 新增
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#update"><i class="fa fa-arrow-circle-o-up"></i> 升级
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#revise"><i class="fa fa-pencil"></i> 修正
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#optimize"><i class="fa fa-magic"></i> 优化
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" style="line-height:1.8em;">
                        <div id="layouts" class="tab-pane active">
                            <div class="panel-body">
                                <ol class="no-left-padding">
                                    <li class="text-danger"><b>推荐：</b>期待已久的contentTabs效果，支持关闭、双击刷新、左右滑动等；</li>
                                    <li>固定左侧主菜单栏，并对菜单项做了新的调整；</li>
                                    <li>增加右侧面板及聊天窗口等。</li>
                                </ol>
                            </div>
                        </div>
                        <div id="new" class="tab-pane">
                            <div class="panel-body">
                                <ol class="no-left-padding">
                                    <li>表单：搜索自动补全插件suggest、高级表单插件（时间选择，切换按钮，图像裁剪上传，单选复选框美化，文件域美化等)等；</li>
                                    <li>图表：图表组合页面等；</li>
                                    <li>页面：团队、社交、客户管理、文章列表、文章详情、新登录页面等；</li>
                                    <li>UI元素：竖向选项卡、拖动面板、文本对比、加载动画、SweetAlert等；</li>
                                    <li>相册：layer相册、Blueimp相册等；</li>
                                    <li>表格：FooTables等。</li>
                                </ol>
                            </div>
                        </div>
                        <div id="update" class="tab-pane">
                            <div class="panel-body">
                                <ol>
                                    <li>页面弹层插件layer升级至1.9.3；</li>
                                    <li>更新jqgrid，支持树形表格；</li>
                                    <li>更新帮助文档。</li>
                                </ol>
                            </div>
                        </div>
                        <div id="revise" class="tab-pane">
                            <div class="panel-body">
                                <ol>
                                    <li>jstree、Simditor等多处错误；</li>
                                    <li>页面加载进度提示；</li>
                                    <li>Glyphicon字体图标不显示的问题；</li>
                                </ol>
                            </div>
                        </div>
                        <div id="optimize" class="tab-pane">
                            <div class="panel-body">
                                <ol>
                                    <li>H+整体视觉效果；</li>
                                    <li>jstree默认主题显示效果；</li>
                                    <li>表单验证显示效果；</li>
                                    <li>iCheck显示效果；</li>
                                    <li>Tabs显示效果。</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </script>

    <!-- 第三方插件 -->
    <script src="{{ asset('js/welcome.js') }}"></script>
@endsection
