@extends('layout._member')

@section('head_css')
    @parent
    <link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
@endsection

@section('content-header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2>会员中心首页</h2>
        </div>
    </div>
@endsection

@section('content')
    <div class="wrapper wrapper-content">
        <!-- 会员信息 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="widget-head-color-box navy-bg p-lg text-center">
                    <div class="m-b-md">
                        <h2 class="font-bold no-margins">
                            <p><span class="text-danger">{{ Auth::user()->nickname?:'' }}</span>&nbsp您好, 欢迎登陆!</p>
                        </h2>
                    </div>
                    <img style="width:100%; max-width:140px;" src="http://jiu.znyes.com/img/a4.jpg" class="img-circle circle-border m-b-md" alt="profile">
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h2>账户余额</h2>
                    </div>

                    <div class="widget style1 navy-bg ibox-content">
                        <div class="row vertical-align">
                            <div class="col-sm-12">
                                <span class="font-bold fa-3x text-danger">{{ Auth::user()->amount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h2>网站数量</h2>
                    </div>

                    <div class="widget style1 navy-bg ibox-content">
                        <div class="row vertical-align">
                            <div class="col-sm-12">
                                <span class="font-bold fa-3x">{{ isset($posterThemes) && count($posterThemes)?count($posterThemes) : '还没有添加网站' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('extraPlugin')
    @parent
            <!-- Data Tables -->
    <script src="{{ asset('js/plugins/jeditable/jquery.jeditable.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>


    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function () {
            $('a.get-js').click(function () {
                html = '<div class="border-bottom white-bg page-heading clearfix">';
                html += '<h2>把下面的代码放入页面&lt;/body&gt;前</h2>';
                html += '<div class="alert alert-info">&lt;script type="text/javascript" src="'+$(this).data('url')+'"&gt;&lt;/script&gt;</div>';
                html +='</div>';
                layer.open({
                    title: '获取JS',
                    type: 1,
                    area: ['600px', 'auto'],
                    shadeClose: false, //点击遮罩关闭
                    content: html,
                    btn: ['确定', '取消'],
                    skin: 'layui-layer-rim' //加上边框
                });
                return false;
            });

            $('.renew').click(
                function(){
                    layer.confirm('is not?', {icon: 3, title:'提示'}, function(index){
                        //do something
                        //return false;
                        layer.close(index);
                    });
                }
            );

            $('.del-form').click(function(){
                //方法一
                //var checkDel = confirm('确定要执行此操作吗?');
                //return checkDel;

                //方法二
                $this = $(this);
                layer.confirm('确认删除?', {icon: 3, title:'提示'},
                    function(index){
                        //do something
                        $this.submit();
                        layer.close(index);
                    }
                );
                return false;
            });

            $('.renew-form').click(function(){
                //方法一
                //var checkDel = confirm('确定要执行此操作吗?');
                //return checkDel;

                //方法二
                $this = $(this);
                amount = $this.data('amount');
                layer.confirm('确认支付'+amount+'元?', {icon: 3, title:'提示'},
                        function(index){
                            //do something
                            $this.submit();
                            layer.close(index);
                        }
                );
                return false;
            });
        });


        $(document).ready(function () {
            /* Init DataTables */
            var oTable = $('#editable').dataTable(
<<<<<<< HEAD
                    {
                        "order": [[ 1, 'asc' ], [2, 'desc']],
                        "columnDefs": [
                            {
                                targets: [0],
                                searchable: false,
                                orderable: false
                            },
                            {
                                targets: [1],
                                searchable: true,
                                orderData: [1, 2]
                            },
                            {
                                targets: [2],
                                searchable: false,
                                orderable: false
                            },
                            {
                                targets: [3],
                                searchable: false,
                                orderable: true
                            },
                            {
                                targets: [4],
                                searchable: false,
                                orderable: false
                            }
                        ]
                    }
=======
                {
                    "order": [[ 1, 'asc' ], [2, 'desc']],
                    "columnDefs": [
                        {
                            targets: [0],
                            searchable: false,
                            orderable: false
                        },
                        {
                            targets: [1],
                            searchable: true,
                            orderData: [1, 2]
                        },
                        {
                            targets: [2],
                            searchable: true,
                            orderable: false
                        },
                        {
                            targets: [3],
                            searchable: false,
                            orderable: true
                        },
                        {
                            targets: [4],
                            searchable: false,
                            orderable: false
                        }
                    ]
                }
>>>>>>> origin/master
            );

            /* Apply the jEditable handlers to the table */
            oTable.$('td.editbale').editable('../example_ajax.php', {
                "callback": function (sValue, y) {
                    var aPos = oTable.fnGetPosition(this);
                    oTable.fnUpdate(sValue, aPos[0], aPos[1]);
                },
                "submitdata": function (value, settings) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition(this)[2]
                    };
                },

                "width": "90%",
                "height": "100%"
            });


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData([
                "Custom row",
                "New row",
                "New row",
                "New row"
            ]);

        };

        //自定义搜索
        $('.dsearch').on('keyup click', function () {
            var tsval = $(".dsearch").val()
            table.search(tsval, false, false).draw();
        });

        //checkbox全选
        $("#checkAll").on("click", function () {
            if ($(this).prop("checked") === true) {
                $("input[name='checkList']").prop("checked", $(this).prop("checked"));
            } else {
                $("input[name='checkList']").prop("checked", false);
            }
        });
    </script>
@endsection
