<?php
/*
	*功能：设置帐户有关信息及返回路径
	*版本：2.0
	*日期：2008-08-01
	*作者：支付宝公司销售部技术支持团队
	*联系：0571-26888888
	*版权：支付宝公司
*/

$partner        = "";       //合作伙伴ID
$security_code  = "";       //安全检验码
$seller_email   = "";       //卖家支付宝帐户
$_input_charset = "utf-8";  //字符编码格式  目前支持 GBK 或 utf-8
$sign_type      = "MD5";    //加密方式  系统默认(不要修改)
$transport      = "https";  //访问模式,你可以根据自己的服务器是否支持ssl访问而选择http以及https访问模式(系统默认,不要修改)
$notify_url     = "http://localhost/php/notify_url.php"; //交易过程中服务器通知的页面 要用 http://格式的完整路径
$return_url     = "http://localhost/php/return_url.php"; //付完款后跳转的页面 要用 http://格式的完整路径
$show_url       = ""        //你网站商品的展示地址

/** 提示：如何获取安全校验码和合作ID
1.访问 www.alipay.com，然后登陆您的帐户($seller_email).
2.点商家服务.导航栏的下面可以看到
*/
?>