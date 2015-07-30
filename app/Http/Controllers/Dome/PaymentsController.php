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
 * ### 阅读=》code, 印象笔记, php手册, stack, google, baidu
 * ### 编码=》
 *
 * ## 编码规范
 * 1.类=>驼峰法
 * 2.其他=>_
 */
namespace App\Http\Controllers\Dome;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

use Input;

class PaymentsController extends Controller {
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

        //创建订单...
        $orderSn = Order::createOrderSn();
        $out_trade_no = $orderSn;

        //保存订单

        //respond到页面的数据
        $data = ['out_trade_no' => $out_trade_no, 'subject' => $out_trade_no.'号订单产品'];

        //return view(...);
        return $data; //暂时返回测试用数据, 需要调用时使用->create()返回数据;
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

        //信息整合,过滤
        $data = Input::all() + $this->create();

        //创建payway
        \Omnipay::setGateway($data['gateway']);

        //获取request
        $resquest = \Omnipay::purchase($data); //request->response

        //获取respond并跳转到第三方支付平台
        $response = $resquest->send();
        $response->redirect();
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
}
