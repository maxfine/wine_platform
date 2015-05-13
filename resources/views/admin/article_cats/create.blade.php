@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">添加文章栏目</div>

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

          <form action="{{ URL('admin/article/cats') }}" method="POST" enctype="muitipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="cat_name" class="form-control" required="required">
            <br>
            <select name="parent_id" id="parentid" class="form-control">
                <option value="0">≡ 作为一级栏目 ≡</option>
                @foreach ($articleCats as $articleCat)
                <option value="{{ $articleCat->id }}">{{ $articleCat->cat_name }}</option>
                @endforeach
                <!--<option value="11">&nbsp;├ 产品限定及服务范围</option>;-->
            </select>
            <br/>

            <input type="file" name="f_img"  required="required">
            

            <br/>
            <textarea name="cat_brief" rows="10" class="form-control" required="required"></textarea>
            <br>
            <button class="btn btn-lg btn-info">新增 栏目</button>
            <input type="submit" class="form-control" value="提交">
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
