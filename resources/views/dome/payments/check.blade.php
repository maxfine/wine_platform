@extends('layout._layer')

@section('mainLayerCon')
    <p>请在新开支付页面完成充值后选择：</p>
    <p><em class="glyphicon glyphicon-ok"></em> 充值成功&nbsp;&nbsp;<span>|</span>&nbsp;&nbsp;你可选择：
        <a href="#" target="_top">查看充值记录</a>
    </p>
    <!--
    <p><em class="glyphicon glyphicon-remove"></em> 充值失败&nbsp;&nbsp;<span>|</span>&nbsp;&nbsp;建议尝试：
        <a href="javascript:;" id="rePay">重新支付</a>&nbsp;&nbsp;
        <a href="javascript:;" id="selectOtherPayType">选择其它方式充值</a>
    </p>
    -->
@endsection