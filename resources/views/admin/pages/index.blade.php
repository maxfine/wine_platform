@extends('layout._back_content')

@section('head_css')
    <link href="{{ asset('css/bootstrap.min.css?v=3.4.0') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css?v=4.3.0') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css?v=3.0.0') }}" rel="stylesheet">
@stop

@section('content')
<div class="wrapper wrapper-content">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">内容管理 - 单页</div>

        <div class="panel-body">

        <a href="{{ URL('admin/pages/create/') }}" class="btn btn-lg btn-primary">新增</a>

          @foreach ($pages as $_v)
            <hr>
            <div class="page">
                <h4>{{ $_v->title }}</h4>
                <div class="content">
                    <p>
                        {{-- $_v->body --}}
                        {!! htmlspecialchars_decode($_v->content); !!}
                    </p>
                </div>
            </div>
            <a href="{{ URL('admin/pages/'.$_v->id.'/edit') }}" class="btn btn-success">编辑</a>

            <form action="{{ URL('admin/pages/'.$_v->id) }}" method="POST" style="display: inline;">
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

@section('extraPlugin')
    <!-- 全局js -->
    <script src="{{ asset('js/jquery-2.1.1.min.js') }}"></script>
    <script src="js/bootstrap.min.js?v=3.4.0"></script>

    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- 数据表 -->
    <script src="{{ asset('js/plugins/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>

    <!-- 自定义js -->
    <script src="js/content.js?v=1.0.0"></script>
@endsection

