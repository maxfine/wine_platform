<?php
namespace App\Http\Controllers\Dome;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Redirect, Input, Auth;

class RespondController extends Controller {
    private $gateway;
    public  $options;

    public function __construct(){

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
    public function respondGet($code = ''){
        if(empty($code))return false;

        \Omnipay::setGateway($code);
        $resquest = \Omnipay::completePurchase(['request_params' => \Input::all()]);
        $response = $resquest->send();
        if($response->isSuccessful()){
            //TODO
            //验证成功
            //更新账户余额
            //更新订单状态
        }else{

        }
    }
}
