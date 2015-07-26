@extends('layout._front')

@section('bootstrapContent')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<!--<div class="panel-heading">当前位置</div>-->

				<div class="panel-body">
                    <ol class="breadcrumb">
                        <li><a href="{{URL('/')}}">Home</a></li>
                        <li><a href="{{URL('/dome')}}">Dome</a></li>
                        <li class="active">在线支付</li>
                    </ol>
				</div>
			</div>
		</div>
	</div>

    {{-- 支付 --}}
    <div class="panel panel-default" data-example-id="togglable-tabs">
        <div class="panel-heading">在线支付</div>
        <div class="panel-body">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">支付宝担保交易</a></li>
                <li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile">网银支付</a></li>
                <li role="presentation"><a href="#whatch" role="tab" id="whatch-tab" data-toggle="tab" aria-controls="whatch">微信扫码支付</a></li>
            </ul>
            {{-- panel-body换成什么标签更好些?或者更好的排版? --}}
            <div id="myTabContent" class="tab-content panel-body">
                <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                    <form action="{{URL('dome/payments')}}" method="POST" target="_blank" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="payway" value="Alipay_Secured">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">支付金额 <small class="text-red">*</small></label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-2">
                                <button class="btn btn-lg btn-info">确认支付</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                    <form action="{{URL('dome/payments')}}" method="POST" target="_blank" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="payway" value="Alipay_Bank">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">支付金额 <small class="text-red">*</small></label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">选择银行<small class="text-red">*</small></label>
                            <div class="col-sm-10">
                                <label class="checkbox-inline">
                                    <input type="radio" name="bankcode" class="form-control" value="" checked>
                                    支付宝
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="bankcode" class="form-control" value="ICBCB2C">
                                    工商银行
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="bankcode" class="form-control" value="CCB">
                                    建设银行
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="bankcode" class="form-control" value="ABC">
                                    农业银行
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="bankcode" class="form-control" value="BOCB2C">
                                    中国银行
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="bankcode" class="form-control" value="HZCBB2C">
                                    杭州银行
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-lg btn-info">确认支付</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="whatch" aria-labelledby="whatch-tab">
                    <p>
                        微信扫码支付
                        <button id="test2" class="btn">测试</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- /end --}}
</div>
@endsection

@section('extraSection')
    <!--引入Layer组件-->
    <script src="{{ asset('js/plugins/layer-v1.9.3/layer/layer.js') }}"></script>
    <script type="text/javascript">
        layer.config({
            skin:'layer-ext-moon',
            extend:'skin/moon/style.css'
        });

        $('form.form-horizontal').submit(function(e){
            //第三方扩展皮肤
            layer.alert('内容', {
                icon: 1,
                //skin: 'layer-ext-moon' //该皮肤由layer.seaning.com友情扩展。关于皮肤的扩展规则，去这里查阅
            });
            /**
            layer.open({
                type: 1,
                area: ['600px', '360px'],
                shadeClose: false, //点击遮罩关闭
                content: '\<\div style="padding:20px;">返回\<\/div>',
                skin: 'layer-ext-moon'
            });
            **/
        })
    </script>
@endsection

