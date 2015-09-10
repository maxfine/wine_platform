<?php
/**
 * Created by maxfine<max_fine@qq.com>.
 * Date: 2015/9/11
 * Time: 0:25
 */
testMktime();

/**
 * mktime(H, i, s, m, d, Y)
 */
function testMktime(){
    $time = mktime(0, 48, 40, 9, 11, 2015);
    echo $time;
    echo '<br/>';
    mt_srand($time);
    echo mt_rand();
}