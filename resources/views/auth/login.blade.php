@extends('layout._front')

@section('bootstrapContent')
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
							<strong>错误提示!</strong><br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">用户名：</label>
							<div class="col-md-6">
								<input type="email" placeholder="你的邮箱" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">密码：</label>
							<div class="col-md-6">
								<input type="password" placeholder="密码" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> 记住用户名
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">登录</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">忘记密码?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
