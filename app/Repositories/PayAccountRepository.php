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

}