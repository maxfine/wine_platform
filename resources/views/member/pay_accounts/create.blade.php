@extends('layout._member')

@section('content-header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2>充值记录</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ URL('member') }}">会员中心</a>
                </li>
                <li>
                    <strong>充值记录</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
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
                    <form action="{{URL('member/pay/recharge')}}" method="POST" target="_blank" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="gateway" value="Alipay_Secured">
                        <input type="hidden" name="quantity" value="1">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">支付金额 <small class="text-red">*</small></label>
                            <div class="col-sm-10">
                                <input type="text" name="total_fee" class="form-control" required="required">
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
                    <form action="{{URL('member/pay/recharge')}}" method="POST" target="_blank" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="gateway" value="Alipay_Bank">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">支付金额 <small class="text-red">*</small></label>
                            <div class="col-sm-10">
                                <input type="text" name="total_fee" class="form-control" required="required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">选择银行<small class="text-red">*</small></label>
                            <div class="col-sm-10">
                                <label class="checkbox-inline">
                                    <input type="radio" name="defaultBank" class="form-control" value="" checked>
                                    支付宝
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="defaultBank" class="form-control" value="ICBCB2C">
                                    工商银行
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="defaultBank" class="form-control" value="CCB">
                                    建设银行
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="defaultBank" class="form-control" value="ABC">
                                    农业银行
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="defaultBank" class="form-control" value="BOCB2C">
                                    中国银行
                                </label>
                                <label class="checkbox-inline">
                                    <input type="radio" name="defaultBank" class="form-control" value="HZCBB2C">
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
    <script type="text/javascript">
        layer.config({
            skin:'layer-ext-moon',
            extend:'skin/moon/style.css'
        });

        $('form.form-horizontal').submit(function(e){
            layer.open({
                type: 2,
                title: '充值信息确认',
                area: '700px',
                shadeClose: false, //点击遮罩关闭
                //content: '<div style="padding:20px;">返回</div>',
                content: ['{{URL("dome/payments/create_check_alert")}}', 'no'],
                skin: 'layui-layer-rim' //加上边框
            });
        })
    </script>
@endsection
