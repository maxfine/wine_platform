<?php
namespace App\Http\Controllers\Dome;

use App\Http\Requests;
use App\Http\Controllers\CommonController;

use Illuminate\Http\Request;

use Redirect, Input, Auth;

class RespondController extends CommonController {
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

        if ($code){
            $payment = $this->get_by_code($_GET['code']);
            if(!$payment) showmessage(L('payment_failed'));
            $cfg = unserialize_config($payment['config']);
            $pay_name = ucwords($payment['pay_code']);
            pc_base::load_app_class('pay_factory','',0);
            $payment_handler = new pay_factory($pay_name, $cfg);
            $return_data = $payment_handler->receive();
            if($return_data) {
                if($return_data['order_status'] == 0) {
                    $this->update_member_amount_by_sn($return_data['order_id']);
                }
                $this->update_recode_status_by_sn($return_data['order_id'],$return_data['order_status']);
                //支付成功
                //showmessage(L('pay_success'),APP_PATH.'index.php?m=pay&c=deposit');
            } else {
                //支付失败
                //showmessage(L('pay_failed'),APP_PATH.'index.php?m=pay&c=deposit');
            }
        } else {
            //支付成功
        }
    }

    /**
     * 更新订单状态
     * @param unknown_type $trade_sn 订单ID
     * @param unknown_type $status 订单状态
     */
    private function update_recode_status_by_sn($trade_sn,$status) {
        $trade_sn = trim($trade_sn);
        $status = trim(intval($status));
        $data = array();
        $this->account_db = pc_base::load_model('pay_account_model');
        $status = return_status($status);
        $data = array('status'=>$status);
        return $this->account_db->update($data,array('trade_sn'=>$trade_sn));
    }

    /**
     * 更新用户账户余额
     * @param unknown_type $trade_sn
     */
    private function update_member_amount_by_sn($trade_sn) {
        $data = $userinfo = array();
        $this->member_db = pc_base::load_model('member_model');
        $orderinfo = $this->get_userinfo_by_sn($trade_sn);
        $userinfo = $this->member_db->get_one(array('userid'=>$orderinfo['userid']));
        if($orderinfo){
            $money = floatval($orderinfo['money']);
            $amount = $userinfo['amount'] + $money;
            $data = array('amount'=>$amount);
            return $this->member_db->update($data,array('userid'=>$orderinfo['userid']));
        } else {
            error_log(date('m-d H:i:s',SYS_TIME).'|  POST: rechange failed! trade_sn:'.$$trade_sn.' |'."\r\n", 3, CACHE_PATH.'pay_error_log.php');
            return false;
        }
    }
}
