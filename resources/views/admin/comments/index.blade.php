@extends('layout._back_content')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">评论管理</div>

        <div class="panel-body">

          @foreach ($comments as $comment)
            <hr>
            <div class="page">
              <div class="content">
                <p>
                  {{ $comment->content }}
                </p>
              </div>
            </div>
            <a href="{{ URL('admin/comments/'.$comment->id.'/edit') }}" class="btn btn-success">编辑</a>

            <form action="{{ URL('admin/comments/'.$comment->id) }}" method="POST" style="display: inline;">
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
