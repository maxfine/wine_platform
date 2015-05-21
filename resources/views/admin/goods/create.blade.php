@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">添加商品</div>

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

          <form action="{{ URL('admin/goods') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="goods_name" class="form-control" required="required">
            <br>
            <select name="cat_id" id="cat_id" class="form-control">
                <option value="0">≡ 作为一级栏目 ≡</option>
                @foreach ($cats as $r)
                <option value="{{ $r->id }}">{{ $r->cat_name }}</option>
                @endforeach
                <!--<option value="11">&nbsp;├ 产品限定及服务范围</option>;-->
            </select>
            <br/>
            <input type="file" name="image">
            <br/>
            {!! Form::file('images[]', array('multiple'=>true)) !!}
            <br/>


            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Select files...</span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="fileupload" type="file" name="files[]" multiple="">
            </span>

            
            <div class="row fileupload-buttonbar" style="padding-left:15px;">  
            <div class="thumbnail col-sm-6">  
                <img id="weixin_show" style="height:180px;margin-top:10px;margin-bottom:8px;"  src="http://placehold.it/180x180" data-holder-rendered="true">  
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="10" aria-valuemax="100" aria-valuenow="0">
                    <div id="weixin_progress" class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>  
                <div class="caption" align="center">  
                    <span id="weixin_upload" class="btn btn-primary fileinput-button">  
                    <span>上传</span>  
                    <input type="file" id="weixin_image" name="weixin_image" multiple>  
                    </span>  
                    <a id="weixin_cancle" href="javascript:void(0)" class="btn btn-warning" role="button" onclick="cancleUpload('weixin')" style="display:none">删除</a>  
                </div>  
            </div>  
            </div>  

            

            <textarea name="desc" rows="10" class="form-control" required="required"></textarea>
            <br>
            <button class="btn btn-lg btn-info">新增文章</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->  
<link rel="stylesheet" href="{{ URL('css/jquery.fileupload.css') }}">  
<link rel="stylesheet" href="{{ URL('css/jquery.fileupload-ui.css') }}">  
<script src="{{ URL('js/vendor/jquery.ui.widget.js') }}"></script>  
<script src="{{ URL('js/jquery.fileupload.js') }}"></script>  
<script src="{{ URL('js/jquery.iframe-transport.js') }}"></script>
<script type="text/javascript">
$(function() {  
    $("#weixin_image").fileupload({  
        url: {{ URL('admin/goods/weixin_image/uploadImg') }},  
        sequentialUploads: true  
    }).bind('fileuploadprogress', function (e, data) {  
        var progress = parseInt(data.loaded / data.total * 100, 10);  
        $("#weixin_progress").css('width',progress + '%');  
        $("#weixin_progress").html(progress + '%');  
    }).bind('fileuploaddone', function (e, data) {  
        $("#weixin_show").attr("src",""+data.result);  
        $("#weixin_upload").css({display:"none"});  
        $("#weixin_cancle").css({display:""});  
    });  
         
});  
</script>
@endsection

            
