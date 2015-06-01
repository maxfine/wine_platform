@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">编辑属性</div>

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

          <form action="{{ URL('admin/attrs/'.$attr->id) }}" method="POST" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="attr_name" class="form-control" required="required" value="{{ $attr->attr_name }}">
            <br>
            <select name="type_id" id="type_id" class="form-control">
                <option value="0">≡ 修改栏目 ≡</option>
                @foreach ($types as $r)
                <option value="{{ $r->id }}" @if (isset($attr) && $r->id == $attr->type_id ) selected="true" @endif>{{ $r->type_name }}</option>
                @endforeach
                <!--<option value="11">&nbsp;├ 产品限定及服务范围</option>;-->
            </select>

            <br/>
            <div class="form-inline">
                <lable class="checkbox-inline col-sm-2">是否需要检索:</lable>
                <lable class="checkbox-inline"><input name="attr_index" value="0" type="radio" @if ($attr->attr_index == 0 ) checked="true" @endif/>不需要检索</lable>
                <lable class="checkbox-inline"><input name="attr_index" value="1" type="radio" @if ($attr->attr_index == 1 ) checked="true" @endif/>关键字检索</lable>
                <lable class="checkbox-inline"><input name="attr_index" value="2" type="radio" @if ($attr->attr_index == 2 ) checked="true" @endif/>范围检索</lable>
            </div>
            <!--
            <br/>
            <div class="form-inline">
                <lable class="checkbox-inline col-sm-2">属性是否可选:</lable>
                <lable class="checkbox-inline"><input name="attr_type" value="0" type="radio" @if ($attr->attr_type == 0 ) checked="true" @endif/>唯一属性</lable>
                <lable class="checkbox-inline"><input name="attr_type" value="1" type="radio" @if ($attr->attr_type == 1 ) checked="true" @endif/>单选属性</lable>
                <lable class="checkbox-inline"><input name="attr_type" value="2" type="radio" @if ($attr->attr_type == 2 ) checked="true" @endif/>多选属性</lable>
            </div>
            -->
            <br/>
            <div class="form-inline">
                <lable class="checkbox-inline col-sm-2">该属性值的录入方式:</lable>
                <lable class="checkbox-inline"><input name="attr_input_type" value="0" type="radio" @if ($attr->attr_input_type == 0 ) checked="true" @endif/>手工录入</lable>
                <lable class="checkbox-inline"><input name="attr_input_type" value="1" type="radio" @if ($attr->attr_input_type == 1 ) checked="true" @endif/>从下面的列表中选择（一行代表一个可选值）</lable>
                <!--<lable class="checkbox-inline"><input name="attr_input_type" value="2" type="radio" @if ($attr->attr_input_type == 2 ) checked="true" @endif/>多行文本框</lable>-->
            </div>
            <br/>
                <lable class="checkbox-inline col-sm-2">可选值列表:</lable>
                <textarea name="attr_value" rows="5" cols="30" class="" required="required">@if ($attr->attr_value) {{ $attr->attr_value }} @endif</textarea>
            <br>
            <button class="btn btn-lg btn-info">修改</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
