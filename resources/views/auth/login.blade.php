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

                            {!! Form::open(['url'=>'auth/login', 'method' => 'POST', 'role' => 'form']) !!}

                                <!--- Email Field --->
                                <div class="form-group">
                                    {!! Form::label('email', 'Email:') !!}
                                    {!! Form::email('email', null, ['class' => 'form-control input-lg', 'placeholder' => '你的邮箱']) !!}
                                </div>

                                <!--- Password Field --->
                                <div class="form-group">
                                    {!! Form::label('password', '密码:') !!}
                                    {!! Form::password('password', ['class' => 'form-control input-lg']) !!}
                                </div>

                                <div class="form-group text-left">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('remember', '') !!}记住用户名
                                            </label>
                                        </div>
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
@endsection
