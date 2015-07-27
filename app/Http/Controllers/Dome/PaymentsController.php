<?php
namespace App\Http\Controllers\Dome;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Redirect, Input, Auth;

class PaymentsController extends Controller {
    private $payway;
    private $price;
    private $sn;
    private $subject;
    private $bankcode;
    private $quantity;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $payments = null;
        return view('dome.payments.index')->with('payments', $payments);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
        $this->validate($request, [
            'payway' => 'required',
            'price' => 'required|min:1',
        ]);

        $this->price = Input::get('price');
        $this->sn = $this->createSn();
        $this->subject = $this->getSubject();
        $this->bankcode = Input::get('bankcode');
        $this->quantity = Input::get('quantity');
        $this->setPayway(Input::get('payway'), $this->bankcode);

        //进行第三方支付网站跳转
        \Omnipay::setGateway($this->payway);
        $options = $this->getOptions();
        $response = \Omnipay::purchase($options)->send(); //request->response
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

    /**
     * --------------------------------------------------------------
     * 弹出层内嵌iframe-充值信息确认
     * --------------------------------------------------------------
     * @return \Illuminate\View\View
     */
    public function check(){
        return view('dome.payments.check');
    }

    /**
     * --------------------------------------------------------------
     * 服务器端post响应
     * --------------------------------------------------------------
     */
    public function respondPost(){

    }

    /**
     * --------------------------------------------------------------
     * 更新账户余额
     * --------------------------------------------------------------
     */
    public function updateMemberAmountBySn(){

    }

    /**
     * --------------------------------------------------------------
     * 更新订单状态
     * --------------------------------------------------------------
     */
    public function updateRecodeStatusBySn(){

    }

    /**
     * --------------------------------------------------------------
     * 服务器端get响应
     * --------------------------------------------------------------
     */
    public function respondPost(){
    }

    private function createSn(){
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * --------------------------------------------------------------
     * 获取产品名称
     * --------------------------------------------------------------
     * @return string
     */
    private function getSubject(){
        return '产品支付';
    }

    /**
     * --------------------------------------------------------------
     * 设置支付接口
     * --------------------------------------------------------------
     */
    private function setPayway($paywayTemp, $bankcode = ''){
        $payway = '';

        if(!$paywayTemp) return $payway;

        if($paywayTemp == 'Alipay_Bank' && !$bankcode){
            $payway = 'Alipay_Express';
        }else{
            $payway = $paywayTemp;
        }

        $this->payway = $payway;
    }

    /**
     * --------------------------------------------------------------
     * 获取支付接口
     * --------------------------------------------------------------
     * @return mixed
     */
    private function getPayway(){
        return $this->payway;
    }

    /**
     * --------------------------------------------------------------
     * 设置配置项
     * --------------------------------------------------------------
     */
    private function getOptions(){
        $payway = $this->getPayway();
        $options = [];

        if(!$payway)return false;

        if($payway == 'Alipay_Bank'){
            $options = [
                'out_trade_no' => $this->sn, //共有
                'subject'      => $this->subject ? $this->subject : '产品支付', //共有
                'total_fee'    => $this->price, //即时支付接口总费用
                'defaultBank'  => $this->bankcode ? $this->bankcode : '', //网银支付网关
            ];
        }elseif($payway == 'Alipay_Express'){
            $options = [
                'out_trade_no' => $this->sn, //共有
                'subject'      => $this->subject ? $this->subject : '产品支付', //共有
                'total_fee'    => $this->price, //即时支付接口总费用
            ];
        }elseif($payway == 'Alipay_Secured'){
            $options = array(
                'out_trade_no' => $this->sn, //共有
                'subject'      => $this->subject ? $this->subject : '产品支付', //共有
                'price'        => $this->price, //担保交易商品单价
                'quantity'     => $this->quantity ? $this->quantity : 1, //担保交易商品数量
            );
        }

        return $options;
    }














}
