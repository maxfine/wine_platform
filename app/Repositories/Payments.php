<?php
/**
 * Created by maxfine
 * User: max_fine@qq.com
 * Date: 2015/7/30
 * Time: 14:00
 * 交易管理类
 */

namespace App\Repositories;


class Payments {
    public $options; //配置数组
    public $payway; //支付对象
    public $inputs; //传入的参数

    public function __construct($gateway){
    }

    /**
     * ----------------------------------------------------------------
     * 设置输入
     * ----------------------------------------------------------------
     * @param $inputs
     * @return bool
     */
    public function setInputs($inputs){
        if(empty($inputs) || !is_array($inputs))return false;
        $this->inputs = $inputs;
    }

    /**
     * ----------------------------------------------------------------
     * 获取配置数组
     * ----------------------------------------------------------------
     * @return array|bool
     */
    public function getOptionsByInputs(){
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

    /**
     * --------------------------------------------------------------
     * 更新账户余额
     * --------------------------------------------------------------
     */
    public function updateMemberAmountBySn(){
        //to-done
    }

    /**
     * --------------------------------------------------------------
     * 更新订单状态
     * --------------------------------------------------------------
     */
    public function updateRecodeStatusBySn(){
        //to-done
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
}