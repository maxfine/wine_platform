@extends('layout._back_content')

@section('content-header')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>单页</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin') }}">主页</a>
            </li>
            <li>
                <a href="{{ URL('admin/pages') }}">内容管理 - 单页</a>
            </li>
            <li>
                <strong>单页列表</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

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
@endsection
