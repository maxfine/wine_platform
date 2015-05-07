<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>H+ 后台主题UI框架 - 登录</title>
    <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
    <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">

    <link href="http://hplus.oss.aliyuncs.com/css/bootstrap.min.css?v=3.3.0" rel="stylesheet">
    <link href="http://hplus.oss.aliyuncs.com/font-awesome/css/font-awesome.css?v=4.3.0" rel="stylesheet">

    <link href="http://hplus.oss.aliyuncs.com/css/animate.css" rel="stylesheet">
    <link href="http://hplus.oss.aliyuncs.com/css/style.css?v=2.1.0" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">H+</h1>

            </div>
            <h3>欢迎使用 H+</h3>




            <form class="m-t" role="form" method="POST" action="{{ url('/auth/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input name="email" type="email" class="form-control" placeholder="用户名" required="" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="密码" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>



            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="http://hplus.oss.aliyuncs.com/js/jquery-2.1.1.min.js"></script>
    <script src="http://hplus.oss.aliyuncs.com/js/bootstrap.min.js?v=3.3.0"></script>

    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>

</body>

</html>
