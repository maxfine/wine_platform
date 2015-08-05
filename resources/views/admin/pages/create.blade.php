@extends('layout._back')

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
                    <strong>创建单页</strong>
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
                    <div class="panel-heading">新增 Page</div>

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

                        <form action="{{ URL('admin/pages') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label>标题 <small class="text-red">*</small></label>
                                <input type="text" name="title" class="form-control" required="required" value="{{ Input::old('title') }}">
                            </div>

                            <div class="form-group">
                                <label>正文 <small class="text-red">*</small></label>
                                <textarea class="form-control" id="ckeditor" name="body">{{ Input::old('body') }}</textarea>
                                @include('scripts.endCKEditor'){{-- 引入CKEditor编辑器相关JS依赖 --}}
                            </div>

                            <div class="form-group">
                                <div id="uploader-demo" class="wu-example row">
                                        <div id="filePicker" class="col-sm-2" style="width: 120px;">选择图片</div>
                                        <div id="fileList" class="col-sm-10">
                                            <!--<img class="img-thumbnail" src="https://placeholdit.imgix.net/~text?txtsize=20&txt=100%C3%97100&w=100&h=100">-->
                                        </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-lg btn-info">提交</button>
                                    </div>
                                </div>
                            </div>
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
    </script>
@stop

@section('filledScript')
@stop