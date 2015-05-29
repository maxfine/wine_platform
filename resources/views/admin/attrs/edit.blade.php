@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">编辑文章</div>

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

          <form action="{{ URL('admin/articles/'.$article->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="title" class="form-control" required="required" value="{{ $article->title }}">
            <br>
            <select name="cat_id" id="catid" class="form-control">
                <option value="0">≡ 修改栏目 ≡</option>
                @foreach ($articleCats as $cat)
                <option value="{{ $cat->id }}" @if ($cat->id == $article->cat_id) selected="true" @endif>{{ $cat->cat_name }}</option>
                @endforeach
                <!--<option value="11">&nbsp;├ 产品限定及服务范围</option>;-->
            </select>

            <br>
            <input type="file" name="image">
            @if ($article->image)<img src="{{ URL($article->image) }}" width="100" height="100">@endif
            
            <br>
            <textarea name="body" rows="10" class="form-control" required="required">{{ $article->body }}</textarea>
            <br>
            <button class="btn btn-lg btn-info">修改</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
