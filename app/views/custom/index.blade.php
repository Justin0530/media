@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="{{URL::to('/custom/index')}}" class="current">销售管理</a><a href="{{URL::to('/custom/index')}}" class="tip-bottom">客户信息列表</a>
    </div>
</div>
<br />
<div class="container-fluid">
    {{Form::open(array('url' => '/custom/index','method'=>'post'))}}
    <div>
        <span class="span" style="margin-left: 10px;margin-right: 15px;">
            {{Form::text('custom_name',$custom_name,array('id'=>'custom_name','placeholder'=>'客户名称'))}}
        </span>
        <span class="span" style="margin-left: 10px;margin-right: 15px;">
            {{Form::text('contacts',$contacts,array('id'=>'contacts','placeholder'=>'联系人名称'))}}
        </span>
        <span><?php $statusList = array('0'=>'请选择状态','1'=>'有意向','2'=>'已报价','3'=>'已签约','4'=>'未联系'); ?></span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('status',$statusList,$status,array('id'=>'type','placeholder'=>'园区类别'))}}</span>
        <span class="span2" style="margin-left: 10px;"><input type="submit" value="查询" class="btn btn-success"></span>
    </div>
    {{Form::close()}}
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped with-check">
                        <thead>
                        <tr>
                            <th style="width:30px;">序号</th>
                            <th>客户名称</th>
                            <th>客户属性</th>
                            <th>联系人姓名</th>
                            <th>手机</th>
                            <th>固话</th>
                            <th>Email</th>
                            <th>状态</th>
                            <th>第一次访问时间</th>
                            <th>下次拜访时间</th>
                            <th>更新时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customList as $key => $val)
                        <tr>
                            <td><input type="checkbox" name="lineNum" value="{{$val->id}}"/></td>
                            <td>{{$val->custom_name}}</td>
                            <td>{{custom_type($val->attr)}}</td>
                            <td>{{$val->contacts}}</td>
                            <td>{{$val->mobile}}</td>
                            <td>{{$val->telephone}}</td>
                            <td>{{$val->email}}</td>
                            <td>{{custom_status($val->status)}}</td>
                            <td>{{$val->created_at}}</td>
                            <td>{{date('Y-m-d H:i:s', $val->next_visit_time)}}</td>
                            <td class="center"> {{$val->updated_at}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{$customList->links();}}
            <p style="float: right;">
                <button id="edit" class="btn btn-success"><i class="icon-edit"></i></i>  编辑</button>
                <button id="look" class="btn btn-success"><i class="icon-eye-open"></i></i>  查看</button>
                <button id="addRecord" class="btn btn-success"><i class="icon-bell"></i></i>  设置定期回访时间</button>
                <button id="record" class="btn btn-success"><i class="icon-list-alt"></i></i>  回访记录</button>
            </p>

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
