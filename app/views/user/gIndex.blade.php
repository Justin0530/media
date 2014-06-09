@extends('layout.layout')

@section('content')

<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
    </div>
</div>
<!--End-breadcrumbs-->
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
                            <td>{{$val->status}}</td>
                            <td class="center"> {{$val->author->truename}}</td>
                            <td class="center"> {{$val->updated_at}}</td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <p style="float: right;">
                <button id="add" class="btn btn-success"><i class="icon-plus"></i></i>  增加</button>
                <button id="edit" class="btn btn-success"><i class="icon-edit"></i></i>  编辑</button>
                <button id="del" class="btn btn-success"><i class="icon-remove-circle"></i></i>  删除</button>
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
            alert('asdf');
            var checks = "";
            $(":checkbox[name='lineNum[]']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                }
            });
            checks = checks.substr(0, checks.length - 1);
            alert('====');
            if ($.trim(checks) == '') {
                alert("请选择一个品牌");

                return false;
            } else {
                location.href = "/admin/brand/edit?id=" + checks;
            }
        });

        $(":button[id='lock']").click(function () {
            var checks = "";
            $(":checkbox[name='lineNum[]']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                }
            });
            checks = checks.substr(0, checks.length - 1);

            if ($.trim(checks) == '') {
                //alert("请选择一个品牌");
                $(".alert").fadeToggle("slow", "linear");
                return false;
            } else {
                //$(".alert").fadeToggle("slow","linear");
                //alert("/admin/admin/del?ids="+checks);
                if (confirm('真的要锁定?')) {
                    $.post("/admin/brand/lock?ids=" + checks,
                        function (data) {
                            if (data) {
                                alert('锁定成功！');
                            } else {
                                alert('锁定失败！');
                            }
                            parent.location.reload();
                        }
                    );
                }
            }
        });

        $(":button[id='unlock']").click(function () {
            var checks = "";
            $(":checkbox[name='lineNum[]']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                }
            });
            checks = checks.substr(0, checks.length - 1);

            if ($.trim(checks) == '') {
                //alert("请选择一个品牌");
                $(".alert").fadeToggle("slow", "linear");
                return false;
            } else {
                //$(".alert").fadeToggle("slow","linear");
                //alert("/admin/admin/del?ids="+checks);
                if (confirm('真的要启用?')) {
                    $.post("/admin/brand/unlock?ids=" + checks,
                        function (data) {
                            if (data) {
                                alert('启用成功！');
                            } else {
                                alert('启用失败！');
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