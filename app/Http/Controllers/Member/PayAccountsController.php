<?php namespace App\Http\Controllers\Member;

use App\Http\Requests;
use App\Http\Controllers\Member\MemberController;

use Illuminate\Http\Request;
use App\Repositories\PayAccountRepository;
use Input, Config, Omnipay, Auth;

class PayAccountsController extends MemberController {

    public function __construct(PayAccountRepository $payAccount)
    {
        $this->payAccount = $payAccount;
        parent::__construct();
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $data = [
            'trade_sn' => $request->input('trade_sn'),
            'status' => $request->input('status'),
        ];
        $user_id = Auth::user()->id;
        $payAccounts = $this->payAccount->index($data, $user_id, 10);

        return view('member.pay_accounts.index')->with('payAccounts', $payAccounts);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('member.pay_accounts.create');
	}

	/**
     * 保存订单
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        //验证input信息
        $this->validate($request, [
            'payment' => 'required',
            'money' => 'required|numeric|min:0.01'
        ]);

        $user_id = Auth::user()->id;
        $this->payAccount->store(Input::all(), $user_id);

        /**
        //订单数据,暂时使用测试数据
        $data = ['out_trade_no' => $out_trade_no, 'subject' => $out_trade_no.'号订单产品',  'quantity' => 1, 'defaultBank' => 'CCB']; //保证金额正确性, 订单号,主题,支付金额由订单决定
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
        **/

        return redirect('member/pay_accounts');
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
        $this->payAccount->destroy($id);

        return redirect('member/pay_accounts');
	}

    /**
     * 支付确认页
     * @param $id
     * @return $this|bool
     */
    public function  payConfig($id)
    {
        $payAccount = $this->payAccount->getById($id);
        $statusArr = ['succ', 'failed', 'error', 'timeout', 'cancel'];

        if(!in_array($payAccount->status, $statusArr)) {
            return view('member.pay_accounts.pay_config')->with('payAccount', $payAccount);
        }else{
            return view('member.pay_accounts.pay_config')->withErrors('此订单已经成功支付或已经失效!');
        }
    }


}
