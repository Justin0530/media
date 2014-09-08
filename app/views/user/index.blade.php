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
                    <h5>用户列表</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped with-check">
                        <thead>
                        <tr>
                            <th>

                            </th>
                            <th>真实姓名</th>
                            <th>邮箱</th>
                            <th>电话</th>
                            <th>级别</th>
                            <th>创建时间</th>
                            <th>编辑时间</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userList as $key => $val)
                        <tr>
                            <td><input type="checkbox" name="lineNum" value="{{$val->id}}"/></td>
                            <td>{{$val->truename}}</td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->mobile}}</td>
                            <td>{{$val->grade->grade_name}}</td>
                            <td class="center"> {{$val->created_at}}</td>
                            <td class="center"> {{$val->updated_at}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
            {{$userList->links();}}
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
            location.href = "/user/add";
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
                alert("请选择一个用户");
                return false;
            } else {
                location.href = "{{URL::to('user/edit')}}/" + checks;
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
                alert("请选择一个用户");
                return false;
            } else {
                if (confirm('真的删除该用户吗?')) {
                    $.post("{{URL::to('user/del')}}/" + checks,
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

        $(":button[id='unlock']").click(function () {
            var checks = "";
            var num = 0;
            $(":checkbox[name='lineNum[]']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                    num++;
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
