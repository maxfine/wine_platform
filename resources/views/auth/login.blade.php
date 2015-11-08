@extends('layout._front')

@section('head_css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/plugins/iCheck/custom.css') }}"/>
@stop

@section('bootstrapContent')
    <div class="wrapper-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <!--<div class="panel-heading">当前位置</div>-->

                        <div class="panel-body">
                            <ol class="breadcrumb">
                                <li><a href="{{URL('/')}}">首页</a></li>
                                <li class="active">用户登录</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">用户登录</div>
                        <div class="panel-body">
                            @include('widgets.error_msg')

                            {!! Form::open(['url'=>'auth/login', 'method' => 'POST', 'role' => 'form', 'id' => 'loginForm']) !!}

                            <!--- Email Field --->
                            <div class="form-group">
                                {!! Form::label('email', 'Email:') !!}
                                {!! Form::email('email', null, ['class' => 'form-control input-lg', 'placeholder' => '你的邮箱', 'required' => '', 'aria-required' => true]) !!}
                            </div>

                            <!--- Password Field --->
                            <div class="form-group">
                                {!! Form::label('password', '密码:') !!}
                                {!! Form::password('password', ['class' => 'form-control input-lg', 'required' => '', 'aria-required' => true]) !!}
                            </div>

                            <div class="form-group text-left i-checks">
                                    <label>
                                        {!! Form::checkbox('remember', '') !!} 记住用户名
                                    </label>
                            </div>

                            <div class="form-group">
                                {!! Form::submit('登录', ['class' => 'btn btn-danger btn-lg btn-block']); !!}
                            </div>

                            {!! Form::close() !!}

                            <p>
                                <a class="text-muted" href="{{ url('/password/email') }}">忘记密码?</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop

@section('extraSection')
    <!-- jQuery Validation plugin javascript-->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <script src="{{  asset('js/plugins/validate/messages_zh.min.js') }}"></script>
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".i-checks").iCheck({
                checkboxClass:"icheckbox_square-green",
                radioClass: 'icheckbox_square-green'
            })
        });
        //以下为修改jQuery Validation插件兼容Bootstrap的方法，没有直接写在插件中是为了便于插件升级
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                element.closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    error.appendTo(element.parent().parent().parent());
                } else {
                    error.appendTo(element.parent());
                }
            },
            errorClass: "help-block m-b-none",
            validClass: "help-block m-b-none"


        });

        //以下为官方示例
        $().ready(function () {
            // validate the comment form when it is submitted
            $("#loginForm").validate();
        });
    </script>

@stop{{-- 用户后期扩展时需要补充的一些代码片段 --}}
