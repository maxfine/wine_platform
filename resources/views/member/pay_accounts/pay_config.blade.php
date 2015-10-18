@extends('layout._member')

@section('content-header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
        <h2>在线充值</h2>
        <ol class="breadcrumb">
                <li>
                    <a href="{{ URL('member') }}">会员中心</a>
                </li>
                <li>
                    <strong>在线充值</strong>
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
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (isset($payAccount) && $payAccount)
            <div class="row">
                <div class="col-sm-12">
                    <h2>支付金额: <strong class="text-danger">{{ $payAccount->money }}元</strong></h2>
                    <h2>支付方式: 支付宝</h2>
                </div>
            </div>

            {{-- panel-body换成什么标签更好些?或者更好的排版? --}}
            <form action="{{URL('pay/payment')}}" method="POST" target="_blank" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="gateway" value="{{ $payAccount->payment }}">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="out_trade_no" value="{{ $payAccount->trade_sn }}">
                <input type="hidden" name="total_fee" value="{{ $payAccount->money }}">
                <div class="form-group">
                    <div class="col-sm-6">
                        <button class="btn btn-lg btn-danger">立即支付</button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
    {{-- /end --}}
</div>
@endsection
