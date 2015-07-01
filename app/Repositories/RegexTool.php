<?php
/**
 * Created by 正言网络科技
 * User: max_fine@qq.com
 * Date: 2015/6/30
 * Time: 16:07
 * 验证工具类
 * 验证规则集合
 * 需要验证的字符串
 * 用法: $regex = new RegexToll(true, 'g');
 * $regex->isEmail($str);
 */

namespace App\Repositorise;

class RegexTool {
    private $validate = [
        'require' => '/\S+/', //不包含不可见原子
        'number' => '/^\d+$/',
        'integer' => '/^(\-|\+)?\d+$/',
        'double' => '/^[\-\+]?\d+(\.\d+)?$/',
        'qq' => '/^\d{5,11}$/',
        'english' => '/^[a-zA-Z]+$/',
        'eamil' => '/^\w+(\-\w+|\.\w+)*\@[a-zA-Z0-9]+((\.|\-)[a-zA-Z0-9]+)*\.[a-zA-Z0-9]+$/',
        'mobile' => '/^0?(13|14|15|17|18)\d{9}$/',
        'url' => '/^https?://([\w-]+\.)+[\w-]+(/+[\w\-\.?=&%]*)*$/',
    ];
    private $fixMod =  null;
    private $matches = []; //匹配结果集
    private $isMatch = false; //是否匹配
    private $returnMatchResult = false; //是否返回结果集

    public function __construct($returnMatchResult = false, $fixMod = ''){
        $this->returnMatchResult = $returnMatchResult;
        $this->fixMod = $fixMod;
    }

    /**
     * @param $pattern
     * @param $subject
     * @return array|bool
     * 匹配并返回结果
     */
    private function regex($pattern, $subject){
        //$validate是否有$pattern, 如果有key等于$pattern则等于此值,如果没有则使用自身
        if(array_key_exists($pattern, $this->validate)){
            $pattern = $this->validate[$pattern].$this->fixMod;
        }
        $this->returnMatchResult ?
        preg_match_all($pattern, $subject, $this->matches) :
        $this->isMatch = preg_match($pattern, $subject) ===  1;

        return $this->getRegexResult();
    }

    /**
     * @return array|bool
     * 获取结果
     */
    private function getRegexResult(){
        if($this->returnMatchResult){
            return $this->matches;
        }else{
            return $this->isMatch;
        }
    }

    /**
     * @param null $bool
     * 改变返回结果类型
     */
    public function toggleReturnType($bool = null){
        if(isset($bool)){
            $this->returnMatchResult = is_bool($bool) ? $bool : (bool)$bool;
        }else{
            $this->returnMatchResult = !$this->returnMatchResult;
        }
    }

    /**
     * @param $email
     * @return array|bool
     * 匹配email
     */
    public function isEmail($email){
        return $this->regex('email', $email);
    }

    /**
     * @param $mobile
     * @return array|bool
     * 匹配手机号码
     */
    public function isMobile($mobile){
        return $this->regex('mobile', $mobile);
    }

    /**
     * @param $url
     * @return array|bool
     * 匹配url地址
     */
    public function isUrl($url){
        return $this->regex('url', $url);
    }

    /**
     * @param $str
     * @return array|bool
     * 匹配非空
     */
    public function noEmpty($str){
        return $this->regex('require', $str);
    }
}