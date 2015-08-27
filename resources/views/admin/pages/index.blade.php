@extends('layout._back_content')

@section('head_css')
    <link href="{{ asset('css/bootstrap.min.css?v=3.4.0') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css?v=4.3.0') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css?v=3.0.0') }}" rel="stylesheet">
@stop

@section('content-header')
<div class="row  border-bottom white-bg dashboard-header">
    <div class="col-sm-12">
        <a href="{{ URL('admin/pages/create/') }}" class="btn btn-primary">新&nbsp&nbsp增</a>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content">
  <div class="row">
      <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>内容管理 - 单页</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="{{ URL('admin/pages/create/') }}">新&nbsp&nbsp增</a></li>
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
                    <table class="table table-striped table-bordered table-hover " id="editable">
                        <thead>
                        <tr>
                            <th><input type="checkbox" name="ckSelectAll" id="ckSelectAll"></th>
                            <th>排序</th>
                            <th>ID</th>
                            <th>标题</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($pages as $item)
                        <tr class="gradeA">
                            <td><input type="checkbox" name="ckbox" id="ckbox" category="national" value="S201312122773311|zosh.cn"></td>
                            <td>@if(isset($item->order)){{ $item->order }} @else {{ $item->id }}@endif</td>
                            <td>@if(isset($item->id)){{ $item->id}} @endif</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td class="center" data-editable="disabled">
                                <a href="{{ URL('admin/pages/'.$item->id.'/edit') }}" class="btn btn-success">编辑</a>

                                <form action="{{ URL('admin/pages/'.$item->id) }}" method="POST" style="display: inline;">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button onClick="delcfm()" type="submit" class="btn btn-danger">删除</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th><input type="checkbox" name="ckSelectAll" id="ckSelectAll"></th>
                            <th>排序</th>
                            <th>ID</th>
                            <th>标题</th>
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
            /* Init DataTables */
            var oTable = $('#editable').dataTable(
                {
                    "order": [[ 1, 'asc' ], [2, 'desc']],
                    "columnDefs": [
                        {
                            "targets": [0],
                            "searchable": false,
                            "orderData": false
                        },
                        {
                            "targets": [1],
                            "searchable": false,
                            "orderData": [1, 2]
                        },
                        {
                            "targets": [2],
                            "searchable": true
                        },
                        {
                            "targets": [3],
                            "searchable": true,
                            "orderData": false
                        },
                        {
                            "targets": [4],
                            "searchable": false
                        },
                        {
                            "targets": [5],
                            "searchable": false,
                            "orderData": false
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
                "New row",
                "New row"]);

        }
    </script>
@endsection
