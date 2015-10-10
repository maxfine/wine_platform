<?php namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\PayAccount;

/**
 * 充值订单仓库
 * Created by maxfine<max_fine@qq.com>.
 * Date: 2015/9/12
 * Time: 22:41
 */

class PayAccountRepository extends BaseRepository
{
    public function __construct(PayAccount $payAccount)
    {
        $this->model = $payAccount;
    }

    /**
     * store与update共用, 存储订单
     *
     * @param $payAccount
     * @param $inputs
     * @return bool
     */
    private function savePayAccount($payAccount, $inputs)
    {
        //必要数据: money, quantity, payment
        //输入数据: money, quantity, payment
        //验证inputs

        //程序生成: null
        //需要修改: money, quantity, payment
        $payAccount->money = e($inputs['money']);
        $payAccount->quantity = e($inputs['quantity']);
        $payAccount->payment = e($inputs['payment']); //支付方式

        //输出
        if($payAccount->save()){
            return $payAccount;
        }else{
            return false;
        }
    }

    public function store($inputs, $user_id, $pay_type = 'recharge')
    {
        //必要数据: tradsn, user_id, money, quantity, pay_type, payment, status
        //输入: money, quantity, payment
        //验证inputs

        //程序生成: trade_sn, user_id, pay_type
        //需要修改: money, quantity, payment
        $payAccount = new $this->model;
        $payAccount->trade_sn = $this->createOrderSn();
        $payAccount->user_id = $user_id;
        if($pay_type == 'recharge'){
            $this->savePayAccount($payAccount, $inputs);
        }

        //输出数据
        return $payAccount;
    }

    /**
     * 充值订单列表数据
     *
     * @param array $data
     * @param array|string $user_id
     * @param int $size
     * @return mixed
     */
    public function index($data = [], $user_id, $size = 10)
    {
        $size = intval($size);
        if(!is_int($size)){
            $size = 10;
        }

        $payAccounts = $this->model
                        ->where('user_id', '=', $user_id)
                        ->where( function($query) use ($data) {
                            isset($data['trade_sn']) && $trade_sn = e($data['trade_sn']);
                            isset($data['status']) && $status = e($data['status']);
                            if(!empty($trade_sn)){
                                $query->where('trade_sn', '=', $trade_sn);
                            }
                            if(!empty($status)){
                                $query->where('status', '=', $status);
                            }
                        })
                        ->orderBy('id', 'desc')
                        ->paginate($size);

        return $payAccounts;
    }

    /**
     * 删除充值记录
     *
     * @param int $id
     * @param string $type
     */
    public function destroy($id, $type = '')
    {
        $payAccount = $this->model->findOrFail($id);
        $payAccount->delete();
    }

    /**
     * 创建唯一性订单号
     *
     * @return string
     */
    public function createOrderSn(){
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }
}