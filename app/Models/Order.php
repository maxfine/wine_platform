<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    /**
     * 创建唯一性订单号
     *
     * @return string
     */
    public static function createOrderSn(){
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }
}
