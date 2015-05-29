<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsType extends Model {

    public function goods(){
        return $this->hasMany('App\Models\Goods','type_id');
    }

    /**
     * ----------------------------------------------------
     * 不能使用attributes,与系统冲突
     * ----------------------------------------------------
     */
    public function attrs(){
        return $this->hasMany('App\Models\Attribute','type_id');
    }

    /**
     * -----------------------------------------------------
     * 删除商品类型
     * -----------------------------------------------------
     */
    public function delete(){
        //删除此类型下所有属性
        foreach($this->attrs as $attr){
            $attr->delete();
        }
        //删除本身
        parent::delete();
    }
}
