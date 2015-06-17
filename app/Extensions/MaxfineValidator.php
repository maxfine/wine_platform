<?php
/**
 * Created by 正言网络科技
 * User: max_fine@qq.com
 * Date: 2015/6/9
 * Time: 15:23
 * 扩展自定义验证类
 */

namespace App\Extensions;
use Illuminate\Validation\Validator as Validator;

class MaxfineValidator extends Validator
{
    /*只允许英文字母组合A-Za-z*/
    public function validateEngAlpha($attribute, $value)
    {
        return preg_match('/^[A-Za-z]+$/', $value);
    }
}
