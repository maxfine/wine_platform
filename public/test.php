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

/*
 * --------------------------------------
 * 反射机制
 * --------------------------------------
class testClass
{
    public function testFunc($param1, $param2=0)
    {
 
    }
}
//reflectionMethod 反射类，该类报告了一个访法的有关信息
$method = new ReflectionMethod('testClass','testFunc');
 
$params = $method->getParameters();
foreach ($params as $param) 
{
      echo "param name:".$param->getName()."<BR><BR>";
      if($param->isOptional())
      {
           echo "Default value:".$param->getDefaultValue()."<BR><BR>";
      } 
      if($param->allowsNull() ===true)
      {
          echo "可以为空";
      }else{
          echo "不能为空";
      }
      echo "<BR>=================<BR>";
}
*****************END*******************/

/**
 * --------------------------------------------------------
 * 静态常量与静态变量,静态方法
 * --------------------------------------------------------
 * 都可以使用的调用方式self/this::type
 * 静态常量的值是不能修改的
 * 静态方法中不能出现$this
 *
class Test{
    const type = 2; 

    public function __construct(){
        echo '调用静态常量$this::type='.$this::type;
        echo '<br/>';
        $this::getST(); //等同于Test::getST()
        echo '<br/>';
    }

    public function getType(){
        echo '调用静态常量self::type='.self::type;
    }

    public static function getST(){
        echo '调用了静态方法';
    }
}

$test = new Test;
************END**************/
