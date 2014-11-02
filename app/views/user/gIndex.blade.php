@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">系统管理</a> <a href="#" class="current">级别管理</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-th"></i>
                    </span>
                    <h5>级别列表</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped with-check">
                        <thead>
                        <tr>
                            <th><i class="icon-resize-vertical"></i></th>
                            <th>级别</th>
                            <th>描述</th>
                            <th>权限类型</th>
                            <th>状态</th>
                            <th>编辑者</th>
                            <th>编辑时间</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($gradeList as $key => $val)
                        <tr>
                            <td><input type="checkbox" name="lineNum" value="{{$val->id}}" style="opacity: 1;"/></td>
                            <td>{{$val->grade_name}}</td>
                            <td>{{$val->desc}}</td>
                            <td>
                                @if($val->range=='1')
                                {{'全部'}}
                                @else
                                {{'部分'}}
                                @endif
                            </td>
                            <td>
                                @if($val->status=='1')
                                {{'启用'}}
                                @else
                                {{禁用}}
                                @endif
                            </td>
                            <td class="center"> {{$val->author->truename}}</td>
                            <td class="center"> {{$val->updated_at}}</td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <p style="float: right;">
                <button id="add" class="btn btn-success"><i class="icon-plus"></i>  增加</button>
                <button id="edit" class="btn btn-success"><i class="icon-edit"></i>  编辑</button>
                <button id="look" class="btn btn-success"><i class="icon-eye-open"></i>  查看</button>
                <button id="del" class="btn btn-success"><i class="icon-remove-circle"></i>  删除</button>
            </p>

        </div>
    </div>
</div>
@stop
@section('js')
@parent
<script>
    $(function () {
        $(":button[id='add']").click(function () {
            location.href = "/user/addGrade";
        });

        $(":button[id='edit']").click(function () {
            var checks = "";
            var num = 0;
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                    num  =  num + 1;
                }
            });
            checks = checks.substr(0, checks.length - 1);
            if ($.trim(checks) == ''||num > 1) {
                alert("请选择一个级别");
                return false;
            } else {
                location.href = "{{URL::to('user/editGrade');}}/" + checks;
            }
        });

        $(":button[id='look']").click(function () {
            var checks = "";
            var num = 0;
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                    num  =  num + 1;
                }
            });
            checks = checks.substr(0, checks.length - 1);
            alert(checks);
            if ($.trim(checks) == ''||num > 1) {
                alert("请选择一个级别");
                return false;
            } else {
                location.href = "{{URL::to('user/lookGrade');}}/" + checks;
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
                alert("请选择一个或多个级别");
                return false;
            } else {
                if (confirm('您真的要删除吗?')) {
                    $.post("{{URL::to('user/delGrade')}}/" + checks,
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