<?php
namespace App\Http\Controllers\Pay;

use App\Http\Requests;
use App\Http\Controllers\CommonController;

use Illuminate\Http\Request;
use App\Repositories\PayAccountRepository;
use App\Models\User;

use Omnipay, Redirect, Input, Auth;

class RespondController extends CommonController {
    private $gateway;
    public  $options;

    public function __construct(PayAccountRepository $payAccount){
        $this->payAccount = $payAccount;
    }

    /**
     * --------------------------------------------------------------
     * 服务器端post响应
     * --------------------------------------------------------------
     */
    public function respondPost(){
        if(empty($code))return false;

        Omnipay::setGateway($code);
        $resquest = Omnipay::completePurchase(['request_params' => Input::all()]);
        $data = $resquest->getData();

        $response = $resquest->send();
        if($response->isSuccessful() && $response->isTradeStatusOk()){
            //TODO
            $data = $resquest->getData();
            $out_trade_no = $data['request_params']['out_trade_no'];
            //验证成功
            //更新账户余额
            $this->payAccount->updateMemberAmountBySn($out_trade_no);
            //更新订单状态
            $this->payAccount->updateRecodeStatusBySn($out_trade_no, 'succ');
            die('success');
        }else{
            die('fail');
        }
    }

    /**
     * --------------------------------------------------------------
     * 服务器端get响应
     * --------------------------------------------------------------
     * 返回成功提示,5秒后跳转到指定页面
     *
     * http://jiu.znyes.com/pay/respond_get/Alipay_Express?
     * buyer_email=1526469221%40qq.com&
     * buyer_id=2088002529453464&
     * exterface=create_direct_pay_by_user&
     * is_success=T&
     * notify_id=RqPnCoPT3K9%252Fvwbh3InVamsRRnzgkBhsjug240BTr7SilP%252FZQGH01kDlRndrQgRlTGP8&
     * notify_time=2015-10-13+17%3A12%3A11&
     * notify_type=trade_status_sync&
     * out_trade_no=2015101332567&
     * payment_type=1&
     * seller_email=437630959%40qq.com&
     * seller_id=2088021297824829&
     * subject=2015101332567%E5%8F%B7%E8%AE%A2%E5%8D%95%E4%BA%A7%E5%93%81&
     * total_fee=0.01&
     * trade_no=2015101321001004460000671588&
     * trade_status=TRADE_SUCCESS&
     * sign=550eb0cbc111b6017d5749abf79212b3&
     * sign_type=MD5
     */
    public function respondGet($code = ''){
        if(empty($code))return false;

        Omnipay::setGateway($code);
        $resquest = Omnipay::completePurchase(['request_params' => Input::all()]);
        $data = $resquest->getData();

        $response = $resquest->send();
        if($response->isSuccessful() && $response->isTradeStatusOk()){
            //TODO
            $data = $resquest->getData();
            $out_trade_no = $data['request_params']['out_trade_no'];
            //验证成功
            //更新账户余额
            $this->payAccount->updateMemberAmountBySn($out_trade_no);
            //更新订单状态
            $this->payAccount->updateRecodeStatusBySn($out_trade_no, 'succ');
            //die('success');
        }else{
            die('fail');
        }

        /**
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
        */
    }

}
