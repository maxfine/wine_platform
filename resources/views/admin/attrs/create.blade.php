@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">添加属性</div>

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

          <form action="{{ URL('admin/attrs') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="attr_name" class="form-control" required="required">
            <br>
            <select name="type_id" id="type_id" class="form-control">
                <option value="0">≡ ≡ ≡ 选择类型≡ ≡ ≡ </option>
                @foreach ($types as $r)
                <option value="{{ $r->id }}" @if (isset($type) && $r->id == $type->id) selected="true" @endif>{{ $r->type_name }} </option>
                @endforeach
                <!--<option value="11">&nbsp;├ 产品限定及服务范围</option>;-->
            </select>

            <br/>
            <div class="form-inline">
                <lable class="checkbox-inline col-sm-2">是否需要检索:</lable>
                <lable class="checkbox-inline"><input name="attr_index" value="0" type="radio" checked/>不需要检索</lable>
                <lable class="checkbox-inline"><input name="attr_index" value="1" type="radio"/>关键字检索</lable>
                <lable class="checkbox-inline"><input name="attr_index" value="2" type="radio"/>范围检索</lable>
            </div>
            <br/>
            <div class="form-inline">
                <lable class="checkbox-inline col-sm-2">属性是否可选:</lable>
                <lable class="checkbox-inline"><input name="attr_type" value="0" type="radio" checked/>唯一属性</lable>
                <lable class="checkbox-inline"><input name="attr_type" value="1" type="radio"/>单选属性</lable>
                <lable class="checkbox-inline"><input name="attr_type" value="2" type="radio"/>多选属性</lable>
            </div>
            <br/>
            <div class="form-inline">
                <lable class="checkbox-inline col-sm-2">该属性值的录入方式:</lable>
                <lable class="checkbox-inline"><input name="attr_input_type" value="0" type="radio" checked/>手工录入</lable>
                <lable class="checkbox-inline"><input name="attr_input_type" value="1" type="radio"/>从下面的列表中选择（一行代表一个可选值）</lable>
                <lable class="checkbox-inline"><input name="attr_input_type" value="2" type="radio"/>多行文本框</lable>
            </div>
            <br/>
                <lable class="checkbox-inline col-sm-2">可选值列表:</lable>
                <textarea name="attr_value" rows="5" cols="30" class="" required="required"></textarea>
            <br>
            <button class="btn btn-lg btn-info">确认</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
