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

    public function __construct(){

    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $payments = [


        ];
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
     * 服务器端get响应
     * --------------------------------------------------------------
     * 返回成功提示,5秒后跳转到指定页面
     */
    public function respondGet(){
        //支付宝服务器发送的数据
        /**
        $buyer_email=1526469221%40qq.com; //买家支付宝邮箱
        $buyer_id=2088002529453464; //买家支付宝id
        $exterface=create_direct_pay_by_user; //支付接口类型
        $is_success=T; //是否成功
        $notify_id=RqPnCoPT3K9%252Fvwbh3InSPgy8T3pzxoGMaFYGnySYx%252FPIXtRxZfwpAmqCwjXGOTw44mM1; //发送id
        $notify_time=2015-07-29+16%3A17%3A20; //服务端数据发送时间
        $notify_type=trade_status_sync; //服务端发送数据类型:同步发送
        $out_trade_no=2015072996300; //商户订单号
        $payment_type=1; //付款类型
        $seller_email=437630959%40qq.com; //卖家支付宝邮箱
        $seller_id=2088021297824829; //卖家id
        $subject=%E4%BA%A7%E5%93%81%E6%94%AF%E4%BB%98; //主题
        $total_fee=0.01; //价格
        $trade_no=2015072900001000460059090687; //支付宝订单号
        $trade_status=TRADE_SUCCESS; //支付状态
        $sign=d79ba11387d379256aafa72e64485d9a; //签名
        $sign_type=MD5; //签名加密方式
        **/

        //数据

        //验证数据

        if($avi == true){
            //验证成功

        }else{
            //验证失败
            dd('支付失败');
        }
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
     * 创建唯一订单号
     * --------------------------------------------------------------
     * @return string
     */
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
