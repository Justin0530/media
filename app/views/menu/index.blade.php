@extends('layout.layout')

@section('content')

<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">系统管理</a> <a href="#" class="current">菜单维护</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<!--End-breadcrumbs-->
<br>
{{Form::open(array('url' => '/menu/index','method'=>'post'))}}

            <span class="span" style="margin-left: 20px;margin-right: 15px;">{{Form::text('keyword',$keyword,array('id'=>'keyword','placeholder'=>'关键字'))}}</span>
            <span class="span" style="margin-left: 10px;">{{Form::select('parent_id',array('0'=>'请选择父菜单')+$firstMenuList,$parent_id,array('id'=>'parent_id','placeholder'=>'父级菜单名称'))}}</span>
            <?php $gradeList = array('0'=>'请选择级别','1'=>'一级','2'=>'二级'); ?>
            <span class="span" style="margin-left: 10px;min-width:150px;">{{Form::select('grade',$gradeList,$grade,array('id'=>'grade','placeholder'=>'菜单级别'))}}
            </span>
            <?php $statusList = array(''=>'请选择状态','1'=>'启用','0'=>'禁用'); ?>
            <span class="span" style="margin-left: 10px;min-width:150px;">{{Form::select('status',$statusList,$status,array('id'=>'status','placeholder'=>'菜单状态'))}}
            </span>
            <span class="span" style="margin-left: 10px;min-width:150px;"><input type="submit" value="查询" class="btn btn-success"></span>

    {{Form::close()}}
<div class="container-fluid">

    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title">
                 <span class="icon">
                     <i class="icon-th"></i>
                 </span>
                    <h5>菜单维护</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped with-check">
                        <thead>
                        <tr>
                            <th>

                            </th>
                            <th>菜单名称</th>
                            <th>菜单地址</th>
                            <th>状态</th>
                            <th>菜单等级</th>
                            <th>父级菜单</th>
                            <th>操作用户</th>
                            <th>创建时间</th>
                            <th>编辑时间</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($menuList as $key => $val)
                        <tr>
                            <td><input type="checkbox" name="lineNum" value="{{$val->id}}"/></td>
                            <td>{{$val->menu}}</td>
                            <td>{{$val->menu_url}}</td>
                            <td>
                                @if($val->status=="1")
                                    {{'启用'}}
                                @else
                                    {{'禁用'}}
                                @endif
                            </td>
                            <td>{{$val->menu_grade}}</td>
                            <td>
                                @if($val->parent)
                                {{$val->parent->menu}}

                                @endif
                            </td>
                            <td>{{$val->author->truename}}</td>
                            <td class="center"> {{$val->created_at}}</td>
                            <td class="center"> {{$val->updated_at}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
            {{$menuList->links();}}
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
            location.href = "/menu/add";
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
                alert("请选择一个菜单");
                return false;
            } else {
                location.href = "{{URL::to('menu/edit')}}/" + checks;
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
                if (confirm('真的删除该菜单吗?')) {
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
