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

/**
 * ---------------------------------------------------------
 * 序列化数组serialize, unserialize
 * ---------------------------------------------------------
 * 教程:http://blog.csdn.net/21aspnet/article/details/6908318
$array = array();
$array['key'] = 'website';
$array['value']='www.isoji.org';
$array['value2']='测试';
$a = serialize($array);
echo $a;
unset($array);
$a = unserialize($a);
echo '<hr>';
print_r($a);
***********************END***********************************/


/**
 * -----------------------------------------------------
 * 一行一个值
 * -----------------------------------------------------
$str = 'aaaa
        bbbb
        ccccc
        
        dddd';
$arr = explode(PHP_EOL, $str); //PHP_EOL
var_dump($arr);

var_dump(array_filter(array_map("myfun", $arr)));

function myfun($v){
    if(trim($v)){
        return trim($v); 
    }
}
*************************END*****************************/


/**
 * -----------------------------------------------------
 * array_map
 * -----------------------------------------------------
$attrIdList = [1, 2, 3];
$attrValueList = ['aaa', 'bbb', 'ccc'];
$attrPriceList = [100, 200, 300];
$attrs = array_map('myfun', $attrIdList, $attrValueList, $attrPriceList);
var_dump($attrs);
**********************END*********************************/



/**
 * -----------------------------------------------------------------
 * 双数组查询是否有相同值
 * -----------------------------------------------------------------
$gAttrs = [
            ['id'=>1, 'goods_id'=>1, 'attr_id'=>1, 'attr_value'=>'aaa'],
            ['id'=>2, 'goods_id'=>1, 'attr_id'=>1, 'attr_value'=>'bbb'],
            ['id'=>3, 'goods_id'=>1, 'attr_id'=>1, 'attr_value'=>'eee'],
        ];

$iAttrs = [
            ['goods_id'=>1, 'attr_id'=>1, 'attr_value'=>'aaa'],
            ['goods_id'=>1, 'attr_id'=>1, 'attr_value'=>'bbb'],
            ['goods_id'=>1, 'attr_id'=>1, 'attr_value'=>'ccc'],
        ];

foreach($gAttrs as $v){
    $isDel = true;
    foreach($iAttrs as $_v){
        if($v['goods_id'] == $_v['goods_id'] && $v['attr_id'] == $_v['attr_id'] && $v['attr_value'] == $_v['attr_value']){
            $isDel = false;
        }
    }
    if($isDel){
        $v['sign'] = 'delete'; $attrs[] = $v;
    }
}

var_dump($attrs);
*****************************END**************************************/



/**
 * ------------------------------------------------------------
 * 数组循环中添加数据是否能添加上
 * ------------------------------------------------------------
$arr = [['aaa', 'bbb'], ['ccc', 'ddd']];
foreach($arr as $_v){
    $_v[] = 'fff';
    var_dump($_v);
}
var_dump($arr);

***************************END********************************/


/**
 * ------------------------------------------------------------
 * 对象循环中添加数据是否能添加上
 * ------------------------------------------------------------
$obj = (object)[['aaa', 'bbb'], ['ccc', 'ddd']];
foreach($obj as $_v){
    var_dump($_v);
    echo '<br/>';
    $_v[] = 'zzz';
    var_dump($_v);
    echo '<br/>';
}
    echo '<br/>';
var_dump($obj);
***************************END********************************/


/**
 * ---------------------------------------------------------------
 * 調用靜態方法是否會調用構造函數
 * ---------------------------------------------------------------
class Test{
    public function __construct(){
        echo '<br/>hello';
    }

    public static function sT(){
        echo '<br>static';
    }
}

Test::sT();
-------------------------END-------------------------------------*/

/**
 * 如果a引用b,b又引用c,则a直接引用c, 如果此时b不是引用而是具体值或者null,则a引用b(引用是不可被引用的）
 *
//深入理解PHP对象赋值
//如果a引用b,b又引用c,则a直接引用c, 如果此时b不是引用而是具体值或者null,则a引用b(引用是不可被引用的）
echo '<pre>';

$obj = new StdClass;
$obj->name = 'Pig';
var_dump($obj); //object(stdClass)#1 (1) { ["name"]=> string(3) "Pig" }

$copy = $obj; // $obj ,$copy都是new StdClass返回的同一个标识符的拷贝
var_dump($copy); //object(stdClass)#1 (1) { ["name"]=>string(3) "Pig" }

$copy->name = 'dog';
var_dump($obj); //充分证明对象赋值是引用传递

$objRef = &$obj; // 此时会将$obj转换成引用，然后赋值给$objRef，因此$obj,$objRef都为引用
var_dump($objRef);                  //object(stdClass)#1 (1) { ["name"]=>string(3) "Pig" }
$obj = 'ddd';
var_dump($obj);                    //object(stdClass)#2 (1) { ["name"]=>&string(11) "After Clone" }
var_dump($objRef); //如果a引用b,b又引用c,则a直接引用c, 如果此时b不是引用而是具体值或者null,则a引用b(引用是不可被引用的）
var_dump($copy);
die();

$objClone = clone $obj;             //新空间
$obj->name = 'After Clone';
var_dump($objClone); //object(stdClass)#1 (1) { ["name"]=>string(3) "Pig" }
var_dump($obj);                    //object(stdClass)#1 (1) { ["name"]=>string(11) "After Clone" }

//unset是删除引用效果
$nameRef = &$obj->name;            //$obj->name被转换成引用（& string），然后赋给$nameRef
var_dump($obj);                    //object(stdClass)#2 (1) { ["name"]=>&string(11) "After Clone" }

unset($nameRef); //删除引用
var_dump($obj);                    //object(stdClass)#1 (1) { ["name"]=>string(11) "After Clone" }

//null是赋值效果
$nameRef = &$obj->name;            //恢复name的引用
var_dump($obj);                    //object(stdClass)#2 (1) { ["name"]=>&string(11) "After Clone" }
$nameRef = null;
var_dump($obj);                    //object(stdClass)#2 (1) { ["name"]=>&NULL }

unset($objRef);                    //仅仅删除了引用
var_dump($obj);                    //object(stdClass)#1 (1) { ["name"]=>&NULL }

$objRef = &$obj; //恢复对象引用
$obj->name = 'Lucy';
$obj = null; //赋值$obj为null，$obj只是new StdClass的标识拷贝，不会影响其内容。
//$objRef做为$obj的引用，会同时被赋值null
//等价 $objRef = null;

var_dump($obj,$copy,$objRef,$objClone);
// NULL,
// object(stdClass)#1 (1) { ["name"]=>&string(4) "Lucy" },
// NULL,
// object(stdClass)#1 (1) { ["name"]=>string(3) "Pig" }

 * *********************************END************************************************/

/**
 * ---------------------------------------------------------------------
 * php正则
 * ---------------------------------------------------------------------
 * 字符串查找：preg_match, preg_match_all 区别preg_match查找出第一个,preg_match_all查找所有, 两个函数都把查找的结果引用传递给第三个参数
 * 数组查找：preg_grep匹配数组
 * 字符串与数组替换：preg_replace, preg_filter, 相同点：三参数都可为, 第一和第二个参数数组长度一样, 不同点：preg_filter会过滤掉没有匹配的数据列
 * 整体装换：preg_split
 * 正则符号: ^(![.\-]{?+*}|)$=<>:
$pattern = '/[0-9]/';
$subject = 'abc123def321ghi4';

$j = preg_match($pattern, $subject, $arr1);
$k = preg_match_all($pattern, $subject, $arr2);

show($arr1);
show($arr2);
show($j);
show($k);

$pattern = ['/[0-3]/', '/[4-7]/', '/[8-9]/'];
$replaceMent = ['孔', '思', '凡'];
//$subject = 'abc123def321ghi4';
$subject = ['abc', 'bcd1', 'efg5', 'h4hh8'];

$str1 = preg_replace($pattern, $replaceMent, $subject);
$str2 = preg_filter($pattern, $replaceMent, $subject);
show($str1);
show($str2);

$pattern = '/[0-9]{1,}/';
$subject = 'abc12bcd6ff';

$arr = preg_split($pattern, $subject);

show($arr);

//修正模式
$pattern = '/[iy].*[01]/';
$subject = 'i like you 520520520 you like me 520520520';

$j = preg_match($pattern, $subject, $arr1);
$k = preg_match_all($pattern, $subject, $arr2);

show($arr1);
show($arr2);

function show($v){
    static $n = 0;

    if($n>0){
        echo '<br/>';
        echo '<br/>';
    }
    echo '*****************';
        echo '<br/>';
    echo $n++;
        echo '<br/>';
    echo '*****************';
    echo '<pre>';
    print_r($v);
    echo '</pre>';
}
*****************************END*********************************/

/**
 * ----------------------------------------------------------------
 * 过滤
 * ----------------------------------------------------------------
$email = "som&#e*8-one@example.com";

if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
    echo "E-mail is not valid";
}
else
{
    echo "E-mail is valid";
}
*******************************END********************************/


/**
 * ----------------------------------------------------------------
 * 数组函数
 * ----------------------------------------------------------------
 * array_column:返回输入数组中某一列的值 php>5.5
$a = [
        [
            'aid' => 2,
            'aa' => [
                [
                    'id' => 1,
                    'name' => 'aaaa'
                ],
                [
                    'id' => 3,
                    'name' => 'bbbb'
                ],
                [
                    'id' => 4,
                    'name' => 'dddd'
                ],
            ]
        ],
        [
            'aid' => 3,
            'aa' => [
                [
                    'id' => 1,
                    'name' => 'aaaa'
                ],
                [
                    'id' => 3,
                    'name' => 'bbbb'
                ],
                [
                    'id' => 4,
                    'name' => 'dddd'
                ],
            ]
        ]
];
$ac = array_column($a, 'aa', 'aid');
var_dump($ac);

//array_merge
$a = array(2=>'aaa', 8=>'bbb', 3=>'ccc', 2=>'zzz');
var_dump($a);
var_dump(array_merge($a,array(2=>'vvv')));
*******************************END********************************/

/**
 * ------------------------------------------------------------------
 * 反射参考
 * ------------------------------------------------------------------
$reflector = new \ReflectionClass(__CLASS__); //根据类的命名空间获取反射类
$constructor = $reflector->getConstructor(); //根据反射类获取构造函数反射方法
//$refFunc = new \ReflectionFunction('functionName'); //获取反射函数
$refFunc = new \ReflectionMethod(__CLASS__, 'store'); //获取反射方法
//dd($refFunc->getParameters()[0]->getClass()->newInstance()); //1.获取反射参数ReflectionParameter, 2.获取反射类, 3.获取实例
foreach ($refFunc->getParameters() as $refParameter) {
    echo $refParameter->getName(), '<br />';
}
*******************************END********************************/

























