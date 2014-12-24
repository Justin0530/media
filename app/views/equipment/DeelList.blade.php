@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">系统管理</a> <a href="#" class="current">维修列表</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<div class="content-header">

</div>
<br />
<div class="container-fluid">
    {{Form::open(array('url' => '/equipment/maintain','method'=>'post'))}}
    <div>
        <span class="span" style="margin-left: 10px;margin-right: 15px;">{{Form::text('name',$name,array('id'=>'name','placeholder'=>'园区名称'))}}</span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('province_id',$provinceList,$province_id,array('id'=>'province_id','placeholder'=>'省/直辖市','onclick'=>'regionalData(this,"city_id","City")'))}}</span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('city_id',$cityList,$city_id,array('id'=>'city_id','placeholder'=>'城市','onclick'=>'regionalData(this,"area_id","Area")'))}}</span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('area_id',$areaList,$area_id,array('id'=>'area_id','placeholder'=>'区/县'))}}</span>
        <?php $type_list = array('0'=>'请选择类型','1'=>'公立','2'=>'私立'); ?>
        {{Form::hidden('tmp_city_id',$city_id,array('id'=>'tmp_city_id'))}}
        {{Form::hidden('tmp_area_id',$area_id,array('id'=>'tmp_area_id'))}}
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
                            <th>设备编号</th>
                            <th>城市</th>
                            <th>幼儿园名称</th>
                            <th>地址</th>
                            <th>LED状态</th>
                            <th>画面状态</th>
                            <th>电源状态</th>
                            <th>编辑时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($maintain as $key => $val)
                        <tr>
                            <td><input type="checkbox" name="lineNum" value="{{$val->equipment->id}}"/></td>
                            <td>{{isset($val->equipment->equipment_num)?$val->equipment->equipment_num:''}}</td>
                            <td>{{isset($val->city->city_name)?$val->city->city_name:''}}</td>
                            <td>{{$val->name}}</td>
                            <td>{{$val->address}}</td>
                            <td>{{$val->equipment->led_status=='1'?'正常':'异常'}}</td>
                            <td>{{$val->equipment->frame_status=='1'?'正常':'异常'}}</td>
                            <td>{{$val->equipment->power_source_status=='1'?'正常':'异常'}}</td>
                            <td>{{$val->equipment->created_at}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{$maintain->links();}}
            <p style="float: right;">
                <button id="change" class="btn btn-success"><i class="icon-edit"></i></i>  更换材料</button>
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
            location.href = "/install/add";
        });

        $(":button[id='change']").click(function () {
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
                alert("请选择一个设备");
                return false;
            } else {
                alert('更换材料');
                //return false;
                location.href = "{{URL::to('/equipment/changeMaterial')}}/"+checks;
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
                alert("请选择一个幼儿园");
                return false;
            } else {
                location.href = "{{URL::to('/install/add')}}?act=show&id=" + checks;
            }
        });
        $(":button[id='look']").click(function (){
            location.href = "{{URL::to('/install/add')}}/?id="+checks;
        })
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
