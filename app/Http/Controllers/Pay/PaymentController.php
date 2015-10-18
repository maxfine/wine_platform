<?php
/**
 * Created by 正言网络科技
 * User: max_fine@qq.com
 *
 * 心得：
 * ## 面向对象编程:
 * 1.目标原子化，EG: 商城=》支付系统+订单系统， 支付系统=》付款+服务端接收到支付接口成功返回信息并处理订单与账号余额,
 * 2.编写类,单一原子目标对应单一类
 * 3.类的具体code步骤：面向接口编程,先不写具体实现，先写好方法名->方法具体实现，文字形式流程编写
 * 4.测试数据的预定义, return $data
 *
 * ## MVC分层
 *
 * ## 面向接口阅读，与编码
 * ### 阅读=》code(反射类）, 印象笔记, php手册, stack, google, baidu
 * ### 编码=》
 *
 * ## 编码规范
 * 1.类=>驼峰法
 * 2.其他=>_
 */
namespace App\Http\Controllers\Pay;

use App\Http\Requests;
use App\Http\Controllers\CommonController;
use Illuminate\Http\Request;

use Input, Config, Omnipay;

class PaymentController extends CommonController {
	/**
     * 选择支付接口页面
	 *
	 * @return Response
	 */
	public function index()
	{
        $payments = [
        ]; //可供选择的支付接口信息
        return view('dome.payments.index')->with('payments', $payments);
	}

	/**
     * 创建支付表单
	 *
	 * @return Response
	 */
	public function create()
	{
		//暂时跳过这个步骤，直接进入提交支付表单环节
	}

    private function getOptions()
    {

    }

	/**
     * 提交支付表单
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        //验证input信息
        $this->validate($request, [
            'gateway' => 'required',
        ]);


        $options = array(
            'out_trade_no' => Input::get('out_trade_no'), //共有
            'subject'      => Input::get('out_trade_no').'号订单产品', //共有
            'total_fee' => 0.03, //即时支付接口总费用
            'price'        => '0.01', //担保交易商品单价
            'quantity'     => Input::get('quantity'), //担保交易商品数量
            'defaultBank' => 'CCB', //网银支付网关
        );
        $response = Omnipay::purchase($options)->send(); //request->response

        //创建订单...
        //$orderSn = Order::createOrderSn();
        //$out_trade_no = $orderSn;
        $out_trade_no = Input::get('out_trade_no');
        //保存订单
        //TODO
        //订单数据,暂时使用测试数据
        //$data = ['out_trade_no' => $out_trade_no, 'subject' => $out_trade_no.'号订单产品', 'total_fee' => '0.1', 'quantity' => 1, 'defaultBank' => 'CCB']; //保证金额正确性, 订单号,主题,支付金额由订单决定
        $data = ['out_trade_no' => $out_trade_no, 'subject' => $out_trade_no.'号订单产品', 'quantity' => 1, 'defaultBank' => 'CCB']; //保证金额正确性, 订单号,主题,支付金额由订单决定
        $data = $data + Input::all();
        //创建payway
        $gateway = Input::get('gateway');
        Omnipay::setGateway($gateway);
        //数据对接-按配置参数重组数组
        //如果符合则加入进新数组
        $gateway = Omnipay::getGateway();
        $purchaseParamKeys = Config::get('laravel-omnipay.gateways')[$gateway]['purchaseParamKeys'];
        $parameters = createNewKeyArray($data, $purchaseParamKeys);
        //获取request
        $resquest = Omnipay::purchase($parameters);
        //获取respond并跳转到第三方支付平台
        $response = $resquest->send();

        $response->redirect();
        //$response->getRedirectUrl();
        //$redirectData = $response->getRedirectData();
	}

	/**
     * 展示支付信息
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
     * 编辑支付信息
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
     * 修改支付信息
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
     * 删除支付信息
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    /**
     * 弹出检查充值结果跳转页面
     *
     * @return \Illuminate\View\View
     */
    public function createCheckAlert(){
       return view('dome.payments.check_alert');
    }

    public function getCode($button_attr = '')
    {
        if (strtoupper($this->config['gateway_method']) == 'POST') $str = '<form action="' . $this->config['gateway_url'] . '" method="POST" target="_blank">';
        else $str = '<form action="' . $this->config['gateway_url'] . '" method="GET" target="_blank">';
        $prepare_data = $this->getpreparedata();
        foreach ($prepare_data as $key => $value) $str .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
        $str .= '<input type="submit" ' . $button_attr . ' />';
        $str .= '</form>';
        return $str;
    }
}
