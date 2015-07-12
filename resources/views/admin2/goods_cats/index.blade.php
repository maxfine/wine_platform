@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">商品栏目管理</div>

        <div class="panel-body">

        <a href="{{ URL('admin/goods/cats/create') }}" class="btn btn-lg btn-primary">新增</a>

          @foreach ($cats as $r)
            <hr>
            <div class="page">
              <h4>{{ $r->cat_name }}</h4>
              <div class="content">
                <p>
                  {{ $r->cat_brief }}
                </p>
              </div>
            </div>
            <a href="{{ URL('admin/goods/cats/'.$r->id.'/edit') }}" class="btn btn-success">编辑</a>

            <form action="{{ URL('admin/goods/cats/'.$r->id) }}" method="POST" style="display: inline;">
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
