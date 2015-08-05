@extends('layout._back')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">编辑 Page</div>

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

                    <form action="{{ URL('admin/pages/'.$data->id) }}" method="POST">
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" name="title" class="form-control" required="required" value="{{ Input::old('title', isset($data) ? $data->title : null) }}">
                        <br>

                        <div class="form-group">
                            <label>正文 <small class="text-red">*</small></label>
                            <textarea class="form-control" id="ckeditor" name="body">{{ Input::old('body', isset($data) ? $data->body : null) }}</textarea>
                            @include('scripts.endCKEditor'){{-- 引入CKEditor编辑器相关JS依赖 --}}
                        </div>

                        <div class="form-group">
                            <div id="uploader-demo" class="wu-example row">
                                <div id="filePicker" class="col-sm-2 webuploader-container" style="width: 120px; display: none;"><div class="webuploader-pick">选择图片</div><div style="position: absolute; top: 0px; left: 15px; width: 82px; height: 39px; overflow: hidden; bottom: auto; right: auto;" id="rt_rt_19rukinqs4s3n1b1nr63s71l7h1"><input accept="image/*" class="webuploader-element-invisible" name="file" type="file"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255) none repeat scroll 0% 0%;"></label></div></div>
                                <div id="fileList" class="col-sm-10">
                                    <!--<img class="img-thumbnail" src="https://placeholdit.imgix.net/~text?txtsize=20&txt=100%C3%97100&w=100&h=100">-->
                                    <div id="WU_FILE_0" class="file-item pull-left upload-state-done"><img src="http://jiu.znyes.com/uploads/images/201508/05/66ZHY5PpGc.jpg" class="img-thumbnail"><a class="btn btn-danger btn-block dim btn-outline del-image" href="javascript:void(0);"><i class="fa fa-times"></i> 删除</a><input name="image" value="http://jiu.znyes.com/uploads/images/201508/05/66ZHY5PpGc.jpg" type="hidden"></div></div>
                            </div>
                        </div>

                        <br>
                        <button class="btn btn-lg btn-info">确认提交</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
