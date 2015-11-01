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

                            <form role="form" method="POST" action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="control-label">用户名</label>
                                    <input type="text" class="form-control input-lg" name="name" value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">E-Mail</label>
                                    <input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">密码</label>
                                    <input type="password" class="form-control input-lg" name="password">
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
