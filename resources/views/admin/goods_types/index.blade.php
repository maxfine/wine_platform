@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">商品类型管理</div>

        <div class="panel-body">

        <a href="{{ URL('admin/goods_types/create') }}" class="btn btn-lg btn-primary">新增</a>

          @foreach ($types as $_v)
            <hr>
            <div class="page">
              <h4>{{ $_v->type_name}}</h4>
            </div>
            <a href="{{ URL('admin/goods_types/'.$_v->id.'/edit') }}" class="btn btn-success">编辑</a>

            <form action="{{ URL('admin/goods_types/'.$_v->id) }}" method="POST" style="display: inline;">
              <input name="_method" type="hidden" value="DELETE">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button onClick="delcfm()" type="submit" class="btn btn-danger">删除</button>
            </form>
            <a href="{{ URL('admin/attrs/list/'.$_v->id) }}" class="btn btn-success">查看属性</a>
            <a href="{{ URL('admin/attrs/create/'.$_v->id) }}" class="btn btn-success">添加属性</a>
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
