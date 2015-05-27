@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">商品管理</div>

        <div class="panel-body">

        <a href="{{ URL('admin/goods/create') }}" class="btn btn-lg btn-primary">新增</a>

          @foreach ($goods as $_v)
            <hr>
            <div class="page">
              <h4>{{ $_v->goods_name}}</h4>
              <div class="content">
                <p>
                  {{ $_v->desc}}
                </p>
              </div>
            </div>
            <a href="{{ URL('admin/goods/'.$_v->id.'/edit') }}" class="btn btn-success">编辑</a>

            <form action="{{ URL('admin/goods/'.$_v->id) }}" method="POST" style="display: inline;">
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
