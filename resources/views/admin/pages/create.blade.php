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
                                <input type="text" name="title" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label>正文 <small class="text-red">*</small></label>
                                <textarea class="form-control" id="ckeditor" name="body">{{ Input::old('body', isset($data) ? $data->body : null) }}</textarea>
                                @include('scripts.endCKEditor'){{-- 引入CKEditor编辑器相关JS依赖 --}}
                            </div>

                            <div class="form-group">
                                <label>图片 </label>
                                <!--引入CSS-->
                                <link href="{{ asset('js/plugins/webuploader-0.1.5/webuploader.css') }}" rel="stylesheet">

                                <div id="uploader-demo" class="wu-example">
                                    <div id="fileList" class="uploader-list">
                                    </div>
                                    <div id="filePicker">选择图片</div>
                                </div>
                            </div>

                            <button class="btn btn-lg btn-info">新增 Page</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraPlugin')
    <!--引入JS-->
    <script type="text/javascript" src="{{ asset('js/plugins/webuploader-0.1.5/webuploader.js') }}"></script>
    <script src="{{ asset('js/demo/webuploader-demo2.js') }}"></script>
@endsection
