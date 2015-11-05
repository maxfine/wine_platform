@extends('layout._front')

@section('bootstrapContent')
    <div class="wrapper-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">重置密码</div>
                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>错误提示!</strong><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form  role="form" method="POST" action="{{ url('/password/reset') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="token" value="{{ $token }}">

                                <!--- Email Field --->
                                <div class="form-group">
                                    {!! Form::label('email', 'Email:') !!}
                                    {!! Form::text('email', null, ['class' => 'form-control input-lg', 'placeholder' => '你的邮箱']) !!}
                                </div>

                                <!--- 密码--->
                                <div class="form-group">
                                    {!! Form::label('password', '密码:') !!}
                                    {!! Form::password('password', ['class' => 'form-control input-lg']) !!}
                                </div>

                                <!--- 确认密码--->
                                <div class="form-group">
                                    {!! Form::label('password_confirmation', '确认密码:') !!}
                                    {!! Form::password('password_confirmation', ['class' => 'form-control input-lg']) !!}
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-danger btn-lg btn-block" value="确认" type="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
