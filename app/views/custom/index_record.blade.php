@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="{{URL::to('/custom/index')}}" class="current">销售管理</a><a href="{{URL::to('/custom/index')}}" class="tip-bottom">客户信息列表</a>
        <a href="{{URL::to('/custom/record')}}" class="tip-bottom">回访记录</a>
    </div>
</div>
<br />
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped with-check">
                        <thead>
                        <tr>
                            <th style="width:20px;">序号</th>
                            <th>客户名称</th>
                            <th>备注</th>
                            <th>状态</th>
                            <th>下次拜访时间</th>
                            <th>创建时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recordList as $key => $val)
                        <tr>
                            <td>{{$val->id}}</td>
                            <td>{{$val->custom->custom_name}}</td>
                            <td>{{($val->remark)}}</td>
                            <td>{{custom_status($val->status)}}</td>
                            <td>{{date('Y-m-d H:i:s', $val->next_visit_time)}}</td>
                            <td class="center"> {{$val->updated_at}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{$recordList->links();}}

        </div>
    </div>
</div>
@stop

@section('js')
@parent
<script>
    $(function () {
        $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
        $('select').select2();
        $(":button[id='addRecord']").click(function () {
            var checks = "";
            var num = 0;
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                    num ++;
                }
            });
            checks = checks.substr(0, checks.length - 1);
            if ($.trim(checks) == ''||num>1) {
                alert("请选择一个客户");
                return false;
            } else {
                location.href = "{{URL::to('/custom/editRecord')}}?id="+checks;
            }
        });

        $(":button[id='record']").click(function () {
            var checks = "";
            var num = 0;
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                    num ++;
                }
            });
            checks = checks.substr(0, checks.length - 1);
            if ($.trim(checks) == ''||num>1) {
                alert("请选择一个客户");
                return false;
            } else {
                location.href = "{{URL::to('/custom/record')}}/"+checks;
            }
        });

        $(":button[id='edit']").click(function () {
            var checks = "";
            var num = 0;
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                    num ++;
                }
            });
            checks = checks.substr(0, checks.length - 1);
            if ($.trim(checks) == ''||num>1) {
                alert("请选择一个客户");
                return false;
            } else {
                location.href = "{{URL::to('/custom/edit')}}?id=" + checks;
            }
        });

        $(":button[id='look']").click(function () {
            var checks = "";
            var num = 0;
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                    num ++;
                }
            });
            checks = checks.substr(0, checks.length - 1);
            if ($.trim(checks) == ''||num>1) {
                alert("请选择一个客户");
                return false;
            } else {
                location.href = "{{URL::to('/custom/show')}}?act=show&id=" + checks;
            }
        });

        $(":button[id='del']").click(function () {
            var checks = "";
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                }
            });
            checks = checks.substr(0, checks.length - 1);

            if ($.trim(checks) == '') {
                alert("请选择一个客户");
                return false;
            } else {
                if (confirm('真的删除该客户信息吗?')) {
                    $.post("{{URL::to('menu/del')}}/" + checks,
                        function (data) {
                            if (data) {
                                alert('删除成功！');
                            } else {
                                alert('删除失败！');
                            }
                            parent.location.reload();
                        }
                    );
                }
            }
        });
    });
</script>
@stop
