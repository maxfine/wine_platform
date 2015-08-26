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
                    <strong>修改单页</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
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

                            <div class="form-group">
                                <label>标题<small class="text-red">*</small></label>
                                <input type="text" name="title" class="form-control" required="required" value="{{ Input::old('title', isset($data) ? $data->title : null) }}">
                            </div>

                            <div class="form-group">
                                <label>正文 <small class="text-red">*</small></label>
                                <textarea class="form-control" id="ckeditor" name="content">{{ Input::old('content', isset($data) ? $data->content: null) }}</textarea>
                                @include('scripts.endCKEditor'){{-- 引入CKEditor编辑器相关JS依赖 --}}
                            </div>

                            <div class="form-group">
                                <label>缩略图</label>
                                <div id="uploader-demo" class="wu-example row">
                                    <div id="filePicker" class="col-sm-2" style="width: 120px; @if ($data->thumb) position: absolute; z-index: -99; @endif">选择图片</div>

                                    <div id="fileList" class="col-sm-8">
                                        @if ($data->thumb)
                                            <div id="WU_FILE_DONE" class="file-item pull-left upload-state-done">
                                                <img src="{{ Input::old('thumb', isset($data) ? $data->thumb: null) }}" class="img-thumbnail">
                                                <a class="btn btn-danger btn-block dim btn-outline del-image" href="javascript:void(0);"><i class="fa fa-times"></i> 删除</a>
                                                <input name="thumb" value="{{ Input::old('thumb', isset($data) ? $data->thumb: null) }}" type="hidden">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-lg btn-info">确认提交</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraPlugin')
    @parent
    <!--引入上传插件JS-->
    <script type="text/javascript" src="{{ asset('js/plugins/webuploader-0.1.5/webuploader.js') }}"></script>
    <script src="{{ asset('js/demo/webuploader-demo2.js') }}"></script>
    <script src="{{ asset('js/plugins/layer-v1.9.3/layer/layer.js') }}"></script>
    <!--引入Layer组件-->
    <script type="text/javascript">
        $('form.form-horizontal').submit(function(e){
            layer.open({
                type: 2,
                title: '充值信息确认',
                area: '700px',
                shadeClose: false, //点击遮罩关闭
                //content: '<div style="padding:20px;">返回</div>',
                content: ['{{URL("dome/payments/create_check_alert")}}', 'no'],
                skin: 'layui-layer-rim' //加上边框
            });
        });

        $(function(){
            //$('#filePicker').hide();
            wufile = 'WU_FILE_DONE';
            $( '#'+wufile+' .del-image').on('click', function(e){
                //ajax删除图片, 如果删除成功
                $( '#'+wufile).remove();
                $('#filePicker').css({'position':'relative', 'z-index':'1'}); //显示选择图片按钮
                //todo-如果图片删除失败, 弹出层提示
            });
        });
    </script>
@stop

@section('filledScript')
@stop