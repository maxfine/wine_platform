<?php namespace App\Http\Controllers\Member\Pay;

use App\Http\Requests;
use App\Http\Controllers\Member\MemberController;

use Illuminate\Http\Request;
use App\Models\PayAccount;
use Input, Config, Omnipay, Auth;

class RechargeController extends MemberController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
     * 充值页面
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('member.recharge.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        //验证input信息
        $this->validate($request, [
            'gateway' => 'required',
            'total_fee' => 'required'
        ]);

        //创建订单...
        $orderSn = PayAccount::createOrderSn();
        $out_trade_no = $orderSn;
        //保存订单
        //TODO
        $payAccount = new PayAccount();
        $payAccount->trade_sn = $out_trade_no;
        $payAccount->user_id = Auth::user()->id;
        //订单数据,暂时使用测试数据
        $data = ['out_trade_no' => $out_trade_no, 'subject' => $out_trade_no.'号订单产品', /*'total_fee' => '0.1',*/ 'quantity' => 1, 'defaultBank' => 'CCB']; //保证金额正确性, 订单号,主题,支付金额由订单决定
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
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
