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

    public function store($inputs, $type = 'recharge', $user_id = 0, $pay_id = 0)
    {
        //todo
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