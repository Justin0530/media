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
        <span class="span2" style="margin-left: 10px;">{{Form::select('city_id',array('0'=>'请选择城市')+$cityList,$city_id,array('id'=>'city_id','placeholder'=>'城市名称'))}}</span>
        <span class="span2" style="margin-left: 10px;"><input type="button" value="查询" class="btn btn-success" id="filter"></span>
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
                            <th style="width:20px;">序号</th>
                            <th>设备编号</th>
                            <th>设备状态</th>
                            <th>画面数量</th>
                            <th>安装人员</th>
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
                            <td>{{kStatus($val['equipment_status'])}}</td>
                            <td>{{$val['frames']}}</td>
                            <td>{{$val['erector']}}</td>
                            <td>{{$val['installation_supervisor']}}</td>
                            <td>{{$val['construction_supervisor']}}</td>
                            <td>{{$val['makespan']}}</td>
                            <td align="center">
                                <a href="/equipment/manager/{{$val['id']}}">
                                    <button class="btn btn-success btn-mini">管理</button>
                                </a>
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
            if(!$("#equipment_num").val())
            {
                alert('请输入设备编号');
                return false;
            }
            if(!$("#city_id").val())
            {
                alert('请选择城市');
                return false;
            }
            $("#select").submit();
        });
    })
</script>
@stop
