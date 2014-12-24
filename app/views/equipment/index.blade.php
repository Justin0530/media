@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">系统管理</a> <a href="{{URL::to('equipment/select')}}" class="current">运维管理</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<div class="content-header">

</div>
<br />
<div class="container-fluid">
    {{Form::open(array('url' => '/equipment/select','method'=>'post','id'=>'select'))}}
    <div>
        <span class="span" style="margin-left: 10px;margin-right: 15px;">{{Form::text('equipment_num',$equipment_num,array('id'=>'equipment_num','placeholder'=>'设备名称'))}}</span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('province_id',$provinceList,$province_id,array('id'=>'province_id','placeholder'=>'省/直辖市','onclick'=>'regionalData(this,"city_id","City")'))}}</span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('city_id',$cityList,$city_id,array('id'=>'city_id','placeholder'=>'城市名称','onclick'=>'regionalData(this,"area_id","Area")'))}}</span>
        <span class="span2" style="margin-left: 10px;">{{Form::select('area_id',$areaList,$area_id,array('id'=>'area_id','placeholder'=>'区/县'))}}</span>
        <span class="span2" style="margin-left: 10px;"><input type="button" value="查询" class="btn btn-success" id="filter"></span>
        {{Form::hidden('tmp_city_id',$city_id,array('id'=>'tmp_city_id'))}}
        {{Form::hidden('tmp_area_id',$area_id,array('id'=>'tmp_area_id'))}}
    </div>
    {{Form::close()}}
    <hr>
    @if(isset($eArray)&&count($eArray)>0)
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped with-check">
                        <thead>
                        <tr>
                            <th style="width:30px;">序号</th>
                            <th>设备编号</th>
                            <th>幼儿园名称</th>
                            <th>区域</th>
                            <th>设备状态</th>
                            <th>安装监理人</th>
                            <th>施工监理人</th>
                            <th>完工时间</th>
                            <th>设备管理</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($eArray as $key => $val)
                        <tr>
                            <td>{{$val['id']}}</td>
                            <td>{{$val['equipment_num']}}</td>

                            <td>{{isset($val->kindergarten->name)?$val->kindergarten->name:''}}</td>
                            <td>
                                {{isset($val->kindergarten->province->province)?$val->kindergarten->province->province:''}}
                                {{isset($val->kindergarten->city->city_name)?$val->kindergarten->city->city_name:''}}
                                {{isset($val->kindergarten->area->area)?$val->kindergarten->area->area:''}}
                            </td>
                            <td>{{kStatus($val['equipment_status'])}}</td>
                            <td>{{$val['installation_supervisor']}}</td>
                            <td>{{$val['construction_supervisor']}}</td>
                            <td>{{$val['makespan']}}</td>
                            <td align="center">
                            @if($val['equipment_status']==1)
                            <a href="javascript:alert('该点位尚未安装设备');">
                                <button class="btn btn-success btn-mini">管理</button>
                            </a>

                            @else
                                <a href="/equipment/manager/{{$val['id']}}">
                                    <button class="btn btn-success btn-mini">管理</button>
                                </a>
                            @endif
                            {{Utils::getFrameOper($val['equipment_num'])}}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@stop

@section('js')
@parent
<script>
    $(function () {
        $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
        $('select').select2();

        $(":button[id='filter']").click(function(){

            $("#select").submit();
        });
    })
</script>
@stop
