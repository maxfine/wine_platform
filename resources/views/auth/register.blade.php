@extends('layout._front')

@section('bootstrapContent')
    <div class="wrapper-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <ol class="breadcrumb">
                                <li><a href="{{URL('/')}}">首页</a></li>
                                <li class="active">用户注册</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">注册</div>
                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>错误提示!</strong>
                                    <hr>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="regForm" role="form" method="POST" action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="control-label">用户名</label>
                                    <input type="text" class="form-control input-lg" name="name" value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">E-Mail</label>
                                    <input id="email" type="email" class="form-control input-lg" name="email" value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">密码</label>
                                    <input id="password" type="password" class="form-control input-lg" name="password">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">确认密码</label>
                                    <input type="password" class="form-control input-lg" name="password_confirmation">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-lg btn-block">
                                        确认注册
                                    </button>
                                </div>
                            </form>

                            <p>
                                <a class="text-muted" href="{{ url('/member') }}">已有账号?马上登陆</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
            // validate signup form on keyup and submit
            var icon = "<i class='fa fa-times-circle'></i> ";
            $("#regForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true,
                        remote:{
                            url: "{{ URL('/auth/check_email') }}",
                            type: "POST",
                            dataType: "json",
                            data: {
                                email: function(){
                                    return $("#email").val();
                                },
                                _token: function(){
                                    return $("meta[name = '_token']").attr('content');
                                }
                            }
                        }
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    password_confirmation: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: icon + "请输入您的用户名",
                        minlength: icon + "用户名必须两个字符以上"
                    },
                    email: {
                        required: icon + "请输入您的E-mail",
                        remote: icon + "E-mail已经被使用"
                    },
                    password: {
                        required: icon + "请输入您的密码",
                        minlength: icon + "密码必须5个字符以上"
                    },
                    password_confirmation: {
                        required: icon + "请再次输入密码",
                        minlength: icon + "密码必须5个字符以上",
                        equalTo: icon + "两次输入的密码不一致"
                    }
                }
            });

        });
    </script>
@stop
