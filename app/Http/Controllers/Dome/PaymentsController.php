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
    private $bank;
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

        $payway = Input::get('payway');
        $price = Input::get('price');
        $sn = $this->createSn();
        $subject = $this->getSubject();
        $bank = 'CCB';
        $quantity = Input::get('quantity');

        //进行第三方支付网站跳转
        \Omnipay::setGateway($payway);

        $options = array(
            'out_trade_no' => $sn, //共有
            'subject'      => $subject ? $subject : '产品支付', //共有
            'total_fee'    => $price, //即时支付接口总费用
            'price'        => $price, //担保交易商品单价
            'quantity'     => $quantity ? $quantity : 1, //担保交易商品数量
            'defaultBank'  => $bank ? $bank : 'CCB', //网银支付网关
        );
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

    private function createSn(){
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    private function getSubject(){
        return '产品支付';
    }
}
