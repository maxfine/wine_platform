@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">编辑栏目</div>

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

          <form action="{{ URL('admin/article/cats/'.$articleCat->id) }}" method="POST">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="cat_name" class="form-control" required="required" value="{{ $articleCat->cat_name }}">
            <br>
            <select name="parent_id" id="parentid" class="form-control">
                <option value="0">≡ 作为一级栏目 ≡</option>
                @foreach ($articleCats as $cat)
                <option value="{{ $cat->id }}" @if ($cat->id == $articleCat->parent_id) selected="true" @endif>{{ $cat->cat_name }}</option>
                @endforeach
                <!--<option value="11">&nbsp;├ 产品限定及服务范围</option>;-->
            </select>

            <br>
            <input type="file" name="image"  required="required"><img src="{{ URL($articleCat->image) }}" width="100" height="100">
            
            <br>
            <textarea name="cat_brief" rows="10" class="form-control" required="required">{{ $articleCat->cat_brief }}</textarea>
            <br>
            <button class="btn btn-lg btn-info">修改</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
