@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
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
                  {{ $article->content}}
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
