@extends('layout._member')

@section('head_css')
@parent
<link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
@endsection


@section('content-header')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2>网站列表</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ URL('member') }}">会员中心</a>
                </li>
                <li>
                    <strong>网站列表</strong>
                </li>
            </ol>
        </div>
    </div>

<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-sm-12">
        <div class="pull-left"><a href="{{ URL('member/poster/themes/create/') }}" class="btn btn-primary"><i class="fa fa-plus"></i> 添加网站</a></div>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content">
  <div class="row">
      <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>网站管理 - 单页</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="{{ URL('member/poster/themes/create/') }}">新&nbsp&nbsp增</a></li>
                            <li><a href="table_data_tables.html#">选项1</a>
                            </li>
                            <li><a href="table_data_tables.html#">选项2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <!--<table class="table table-striped table-bordered table-hover " id="editable">-->
                    <table class="table table-striped table-hover " id="editable">
                        <thead>
                        <tr class="info">
                            <th><input type="checkbox" name="ckSelectAll" id="checkAll"></th>
                            <th>ID</th>
                            <th>网址</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($posterThemes as $item)
                        <tr class="gradeA">
                            <td><input type="checkbox" name="checkList"></td>
                            <td>@if(isset($item->id)){{ $item->id}} @endif</td>
                            <td>{{ $item->site_url }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td class="center" data-editable="disabled">
                                <a href="{{ URL('poster/themes/renew/'.$item->id) }}" class="btn btn-danger">续费</a>

                                <a href="javascript:;" data-url="{{ URL('poster/themes/get_js/'.$item->id) }}" class="btn btn-success get-js">获取JS</a>

                                <a href="{{ URL('member/poster/themes/'.$item->id.'/edit') }}" class="btn btn-success">编辑</a>

                                <form action="{{ URL('member/poster/themes/'.$item->id) }}" method="POST" style="display: inline;">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button onClick="delcfm()" type="submit" class="btn btn-danger">删除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="danger">
                            <th><input type="checkbox" name="ckSelectAll" id="checkAll"></th>
                            <th>ID</th>
                            <th>网址</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </tfoot>
                    </table>

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
        });

        $(document).ready(function () {
            /* Init DataTables */
            var oTable = $('#editable').dataTable(
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
