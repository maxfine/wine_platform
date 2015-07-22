@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">payments</div>

				<div class="panel-body">
					You are logged in!
				</div>
			</div>
		</div>
	</div>

    {{-- 支付 --}}
    <div class="panel panel-default" data-example-id="togglable-tabs">
        <div class="panel-heading">在线支付</div>
        <div class="panel-body">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">支付宝支付</a></li>
                <li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile">网银支付</a></li>
                <li role="presentation"><a href="#whatch" role="tab" id="whatch-tab" data-toggle="tab" aria-controls="whatch">微信扫码支付</a></li>
            </ul>
            {{-- panel-body换成什么标签更好些?或者更好的排版? --}}
            <div id="myTabContent" class="tab-content panel-body">
                <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                    <form action="{{URL('payments')}}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>支付金额 <small class="text-red">*</small></label>
                            <input type="text" name="price" class="form-control" required="required">
                        </div>

                        <button class="btn btn-lg btn-info">确认支付</button>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                    <p>
                        网银支付
                    </p>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="whatch" aria-labelledby="whatch-tab">
                    <p>
                        微信扫码支付
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- /end --}}
</div>
@endsection
