<?php
/*
 * ---------------------------------------------------
 * 静态变量
 * ---------------------------------------------------
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
**********************END**************************/

/**
 * ------------------------------------------------
 * trait 变量冲突
 * ------------------------------------------------
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
*********************END***********************/

/*
 * --------------------------------------------------
 * 反射机制
 * --------------------------------------------------
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
***************************END*****************************/

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
**********************END*****************************/


  
/**
 * --------------------------------------------------------
 * 魔术方法__call, __callStatic
 * --------------------------------------------------------
class human{  
  
    private function t(){  
    }  
      
      
    //魔术方法__callStatic  
    public static function __callStatic($method,$arg){  
      
        echo '你想调用我不存在的',$method,'静态方法<br/>';  
        echo '还传了一个参数<br/>';  
        echo print_r($arg),'<br/>';  
    }  
  
}  
  
human::cry('痛哭','鬼哭','号哭');  

//获得每个城市天气预报  
class Action{  
  
    public function tj(){  
        echo '********天气预报<br/>';  
    }  
  
      
    public function __call($m,$p){  
      
        echo $m,'天气预报<br/>';  
    }  
}  
  
$c=new Action();  
$c->tj();  
//获得城市  
$city=$_GET['method'];  
if(isset($city)){  
//获得城市的方法，由魔术方法__call处理  
$c->$city();  
  
}  
***************************END****************************/

/**
 * -------------------------------------------------------
 * array_splice
 * -------------------------------------------------------
 * 替换
$a1=array(0=>"Dog",1=>"Cat",2=>"Horse",3=>"Bird");
$a2=array(0=>"Tiger",1=>"Lion", 2=>'aaaaaaaaaaa');
$a3=array_splice($a1,0,2,$a2);
//$a3=array_splice($a1,0,0,$a2);
print_r($a1);
print_r($a3);
***********************END***********************************/

