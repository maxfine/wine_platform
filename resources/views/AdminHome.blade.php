@extends('layout._back')

@section('content-header')
@parent
<!--
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-sm-12">
                              <blockquote class="text-warning" style="font-size:14px">您是否需要自己做一款后台、会员中心等等的，但是又缺乏html等前端知识…
                              <br>您是否一直在苦苦寻找一款适合自己的后台主题…
                              <br>您是否想做一款自己的web应用程序…
                              <br>…………
                              <h4 class="text-danger">那么，现在H+来了</h4>
                              </blockquote>

                              <hr>
                              </div>
    <div class="col-sm-3">
                             <h2>Hello,Guest</h2>
                             <small>移动设备访问请扫描以下二维码：</small>
                             <br>
                             <br>
                             <img src="img/qr_code.png" width="100%" style="max-width:264px;">
                             <br>
                             </div>
    <div class="col-sm-5">
                             <h2>
                             H+ 后台主题UI框架
                             </h2>
                             <p>H+是一个完全响应式，基于Bootstrap3.4.0最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术，她提供了诸多的强大的可以重新组合的UI组件，并集成了最新的jQuery版本(v2.1.1)，当然，也集成了很多功能强大，用途广泛的jQuery插件，她可以用于所有的Web应用程序，如<b>网站管理后台</b>，<b>网站会员中心</b>，<b>CMS</b>，<b>CRM</b>，<b>OA</b>等等，当然，您也可以对她进行深度定制，以做出更强系统。</p>
                             <p>
                             <b>当前版本：</b>v2.0
                             </p>
                             <p>
                             <b>定价：</b><span class="label label-warning">&yen;768（不开发票）</span>
                             </p>
                             <br>
                             <p>
                             <a class="btn btn-success btn-outline" href="http://wpa.qq.com/msgrd?v=3&uin=516477188&site=qq&menu=yes" target="_blank">
                             <i class="fa fa-qq"> </i> 联系我
                             </a>
                             <a class="btn btn-white btn-bitbucket" href="http://www.zi-han.net" target="_blank">
                             <i class="fa fa-home"></i> 访问博客
                             </a>
                             </p>
                             </div>
    <div class="col-sm-4">
                             <h4>H+具有以下特点：</h4>
                             <ol>
                             <li>完全响应式布局（支持电脑、平板、手机等所有主流设备）</li>
                             <li>基于最新版本的Bootstrap 3.3.0</li>
                             <li>提供4套不同风格的皮肤</li>
                             <li>支持多种布局方式</li>
                             <li>使用最流行的的扁平化设计</li>
                             <li>提供了诸多的UI组件</li>
                             <li>集成多款国内优秀插件，诚意奉献</li>
                             <li>提供盒型、全宽、响应式视图模式</li>
                             <li>采用HTML5 & CSS3</li>
                             <li>拥有良好的代码结构</li>
                             <li>更多……</li>
                             </ol>
                             </div>
</div>
-->
@endsection


@section('content')
@parent
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

@stop

@section('extraPlugin')
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
    <!--统计代码，可删除-->
@endsection
