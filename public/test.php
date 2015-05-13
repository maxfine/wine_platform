<?php
/*
 * ---------------------------
 * 静态变量
 * ---------------------------
class Couter{
    public function inc(){
        static $b = 0;
        $b = $b+1;
        echo $b.'\n';
    }
}

$a = new Couter();
$a->inc();
$b = new Couter();
$b->inc();
************END****************/
/**
 * ------------------------------------
 * trait 变量冲突
 * ------------------------------------
trait T{
    public $t = 1;
}
trait T2{
    public $t2 = 1;
}
class A{
    use T;
    use T2;
    public $t3 =2;
}

$a = new A(); echo $a->t;
***********END*************/
phpinfo();
