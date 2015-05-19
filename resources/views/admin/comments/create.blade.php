@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">添加评论</div>

        <div class="panel-body">

          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ URL('admin/comments') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="post_id" value="{{ $post_id }}">
            <input type="hidden" name="type" value="{{ $type }}">
            <br>
            <textarea name="content" rows="10" class="form-control" required="required"></textarea>
            <br>
            <button class="btn btn-lg btn-info">新增评论</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
