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

          <form action="{{ URL('admin/goods/update/'.$goods->id) }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="goods_name" class="form-control" required="required" value="{{ $goods->goods_name }}">
            <br>
            <div class="input-group">
              <div class="input-group-addon">¥</div>
              <input type="number" name="store_price" value="{{ $goods->store_price}}" class="form-control" required="required" id="exampleInputAmount" placeholder="价格">
              <div class="input-group-addon">.00</div>
            </div>
            <br>
            <select name="cat_id" id="catid" class="form-control">
                <option value="0">≡ 修改栏目 ≡</option>
                @foreach ($cats as $cat)
                <option value="{{ $cat->id }}" @if ($cat->id == $goods->cat_id) selected="true" @endif>{{ $cat->cat_name }}</option>
                @endforeach
                <!--<option value="11">&nbsp;├ 产品限定及服务范围</option>;-->
            </select>

            <br>
            <input type="file" name="image">
            @if ($goods->image)<img src="{{ URL($goods->image) }}" width="100" height="100">@endif
            
            <br>
            <textarea name="desc" rows="10" class="form-control" required="required">{{ $goods->desc}}</textarea>
            {{-- 上传 --}}
            <br/>
            <ul class="row list-unstyled">
            @foreach($photos as $photo)
                <li class="col-xs-4 col-md-2"> <img src="{{ $photo->thumb_url }}" width="100" height="100"/> </li>
            @endforeach
            </ul>
            <br/>
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>添加文件...</span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="fileupload" type="file" name="files[]" multiple>
            </span>
            <br>
            <br>
            <!-- The global progress bar -->
            <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
            </div>
            <!-- The container for the uploaded files -->
            <div id="files" class="files"></div>
            <br>
            <button class="btn btn-lg btn-info">修改</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
<!-- Generic page styles -->
<link rel="stylesheet" href="{{ URL('/') }}/css/fileupload//style.css">
<link rel="stylesheet" href="{{ URL('/') }}/css/fileupload/jquery.fileupload.css">
<style>
#files{overflow:hidden; zoom:1;}
#files .img-box{float:left;}
#photos{overflow:hidden; zoom:1;}
#photos li{float:left; width:100px; height:100px;}
</style>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="{{ URL('/') }}/js/fileupload/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="{{ URL('/') }}/js/fileupload/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="{{ URL('/') }}/js/fileupload/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--<script src="{{ URL('/') }}/js/fileupload/vendor/bootstrap.min.js"></script>-->
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{{ URL('/') }}/js/fileupload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="{{ URL('/') }}/js/fileupload/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="{{ URL('/') }}/js/fileupload/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="{{ URL('/') }}/js/fileupload/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="{{ URL('/') }}/js/fileupload/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="{{ URL('/') }}/js/fileupload/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="{{ URL('/') }}/js/fileupload/jquery.fileupload-validate.js"></script>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'jiu.znyes.com' ?
                '/file/photos' : '/file/photos',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary hidden')
            .prop('disabled', true)
            .text('上传')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('取消')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div class="img-box"/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            //console.log(data.context);
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('上传')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
                    $(data.context.children()[index])
                    .append($('<input type="hidden" name="originalUrls[]"/>').attr('value', file.url))
                    .append($('<input type="hidden" name="thumbUrls[]"/>').attr('value', file.thumbnailUrl));
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('文件上传失败.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
@endsection

