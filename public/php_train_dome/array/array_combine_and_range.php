<?php
/**
 * Created by maxfine<max_fine@qq.com>
 * Date: 2015/9/10
 * Time: 15:50
 *
 * php数组函数练习dome
 */

testRange(10, 20);

function testRange($firstNum = 1, $secondNum = 10){
    var_dump(range($firstNum, $secondNum));
}