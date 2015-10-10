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
        <div class="panel-heading">在线充值</div>
        <div class="panel-body">
            {{-- panel-body换成什么标签更好些?或者更好的排版? --}}
                <form action="{{URL('member/pay_accounts')}}" method="POST" target="_blank" class="form-horizontal">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="payment" value="Alipay_Secured">
                    <input type="hidden" name="quantity" value="1">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">充值金额 <small class="text-red">*</small></label>
                        <div class="col-sm-10">
                            <input type="text" name="money" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-2">
                            <button class="btn btn-lg btn-info">确认</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
    {{-- /end --}}
</div>
@endsection
