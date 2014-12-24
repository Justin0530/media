@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">点位管理</a> <a href="#" class="current">点位汇总</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<br />
<div class="container-fluid">
    {{Form::open(array('method'=>'post'))}}
    <div>
        <span class="span" style="margin-left: 10px;margin-right: 15px;">{{Form::text('name',$name,array('id'=>'name','placeholder'=>'园区名称'))}}</span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('province_id',array('0'=>'请选择省')+$provinceList,$province_id,array('id'=>'province_id','placeholder'=>'省/直辖市','onclick'=>'regionalData(this,"city_id","City")'))}}</span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('city_id',array('0'=>'请选择城市')+$cityList,$city_id,array('id'=>'city_id','placeholder'=>'城市','onclick'=>'regionalData(this,"area_id","Area")'))}}</span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('area_id',array('0'=>'请选择区')+$areaList,$area_id,array('id'=>'area_id','placeholder'=>'区/县'))}}</span>
        <span><?php $type_list = array('0'=>'请选择类型','1'=>'公立','2'=>'私立'); ?></span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('grade_id',array('0'=>'请选择幼儿园等级')+$kindergartenGradeList,$grade_id,array('id'=>'grade_id','placeholder'=>'园区级别'))}}</span>
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
                            <th>点位编号</th>
                            <th>设备编号</th>
                            <th>省/直辖市</th>
                            <th>城市</th>
                            <th>区/县</th>
                            <th>园区名称</th>
                            <th>幼儿园类型</th>
                            <th>幼儿园等级</th>
                            <th>签约状态</th>
                            <th>签约人</th>
                            <th>设备装态</th>
                            <th>安装人</th>
                            <th>下次维护时间</th>
                            <th>添加时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kList as $key => $val)
                        <tr>
                            <td><input type="checkbox" name="lineNum" value="{{$val->id}}"/></td>
                            <td>{{$val->id}}</td>
                            <td>{{$val->equipment?$val->equipment->equipment_num:''}}</td>
                            <td>{{isset($val->province->province)?$val->province->province:''}}</td>
                            <td>{{isset($val->city->city_name)?$val->city->city_name:'';}}</td>
                            <td>{{isset($val->area->area)?$val->area->area:'';}}</td>
                            <td>{{$val->name}}</td>
                            <td>{{$val->type=='1'?'公立':'私立'}}</td>
                            <td>{{isset($val->grade->kindergarten_grade)?$val->grade->kindergarten_grade:''}}</td>
                            <td>{{$val->signing_status=='1'?'已签约':'未签约'}}</td>
                            <td>{{$val->signatory}}</td>
                            <td>{{kStatus($val->equipment?$val->equipment->equipment_status:'')}}</td>
                            <td>{{$val->equipment?Utils::getEquipmentUseStatus($val->equipment->equipment_num):''}}</td>
                            <td class="center"> {{$val->maintain?$val->maintain->next_maintain_time:''}}</td>
                            <td class="center"> {{$val->created_at}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{$kList->links();}}
            <p style="float: right;">
                <button id="maintain" class="btn btn-success"><i class="icon-bookmark-empty"></i></i>  渠道维护</button>
                <button id="edit" class="btn btn-success"><i class="icon-edit"></i></i>  编辑</button>
                <button id="look" class="btn btn-success"><i class="icon-eye-open"></i></i>  查看</button>
            </p>

        </div>
    </div>
</div>
@stop

@section('js')
@parent
<script>
    $(function () {
        $(":button[id='maintain']").click(function () {
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
                alert("请选择一个点位");
                return false;
            } else {
                location.href = "{{URL::to('/install/maintain')}}?kid=" + checks;
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
                alert("请选择一个点位");
                return false;
            } else {
                location.href = "{{URL::to('/install/add')}}?id=" + checks;
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
                location.href = "{{URL::to('/install/show')}}/" + checks;
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
