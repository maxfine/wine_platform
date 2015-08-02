@extends('layout._front')

@section('bootstrapContent')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
                    恭喜您{{ Auth::user()->name }} ，登录成功！
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
