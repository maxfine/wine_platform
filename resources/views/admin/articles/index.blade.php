@extends('layout._back_content')

@section('content-header')
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-sm-12">
            <div class="pull-left"><a href="{{ URL('admin/article/cats/create/') }}" class="btn btn-primary"><i class="fa fa-plus"></i> 添加文章</a></div>
        </div>
    </div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">文章管理</div>

        <div class="panel-body">

        <a href="{{ URL('admin/article/cats/create') }}" class="btn btn-lg btn-primary">新增</a>

          @foreach ($articles as $article)
            <hr>
            <div class="page">
              <h4>{{ $article->title }}</h4>
              <div class="content">
                <p>
                  {{ $article->content }}
                </p>
              </div>
            </div>
            <a href="{{ URL('admin/articles/'.$article->id.'/edit') }}" class="btn btn-success">编辑</a>

            <form action="{{ URL('admin/articles/'.$article->id) }}" method="POST" style="display: inline;">
              <input name="_method" type="hidden" value="DELETE">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button onClick="delcfm()" type="submit" class="btn btn-danger">删除</button>
            </form>
          @endforeach

        <script>
                function delcfm() {
                    if (!confirm("确认要删除？")) {
                        window.event.returnValue = false;
                    }
                }
        </script>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
