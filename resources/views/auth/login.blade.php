@extends('layout._front')

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

                            <form role="form" method="POST" action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="control-label">用户名：</label>
                                    <input type="email" placeholder="你的邮箱" class="form-control input-lg" name="email" value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label class="control-labe">密码：</label>
                                    <input type="password" placeholder="密码" class="form-control input-lg" name="password">
                                </div>

                                <div class="form-group text-left">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> 记住用户名
                                            </label>
                                        </div>
                                </div>

                                <div class="form-group">
                                        <button type="submit" class="btn btn-danger btn-lg btn-block">登录</button>
                                </div>
                            </form>

                            <p>
                                <a class="text-muted" href="{{ url('/password/email') }}">忘记密码?</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
