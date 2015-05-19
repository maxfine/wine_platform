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

//phpinfo();

/*
 * --------------------------------------
 * 反射机制
 * --------------------------------------
 */
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
