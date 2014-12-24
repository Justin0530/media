@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">媒体管理</a> <a href="#" class="current">预售点位列表</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<div class="content-header">

</div>
<br />
<div class="container-fluid">

    {{Form::open(array('url' => '/media/index','method'=>'post'))}}
        <span class="span2">{{Form::select('custom_type_id',array('0'=>'请选择类型')+$customTypeList,$custom_type_id,array('id'=>'custom_type_id','placeholder'=>'客户类型'))}}</span>
        <span class="span2">{{Form::select('province_id',array('0'=>'请选择省')+$provinceList,$province_id,array('id'=>'province_id','placeholder'=>'省/直辖市','onclick'=>'regionalData(this,"city_id","City")'))}}</span>
        <span class="span2">{{Form::select('city_id',array('0'=>'请选择城市')+$cityList,$city_id,array('id'=>'city_id','placeholder'=>'城市','onclick'=>'regionalData(this,"area_id","Area")'))}}</span>
        <span class="span2">{{Form::select('area_id',array('0'=>'请选择区')+$areaList,$area_id,array('id'=>'area_id','placeholder'=>'区/县'))}}</span>
        <span class="span2">{{Form::text('trade_num',$tradeNum,array('id'=>'trade_num','placeholder'=>'预售单号','class'=>'span2'))}}</span>
        <span class="span2">{{Form::text('custom_name',$custom_name,array('id'=>'custom_name','placeholder'=>'客户名称','class'=>'span2'))}}</span>
        <span class="span1"><input type="submit" value="查询" class="btn btn-success"></span>
        {{Form::hidden('tmp_city_id',$city_id,array('id'=>'tmp_city_id'))}}
        {{Form::hidden('tmp_area_id',$area_id,array('id'=>'tmp_area_id'))}}
    {{Form::close()}}

    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped with-check">
                        <thead>
                        <tr>
                            <th style="width:20px;">序号</th>
                            <th>预售单号</th>
                            <th>点位编号</th>
                            <th>城市</th>
                            <th>客户类型</th>
                            <th>客户名称</th>
                            <th>画面数量</th>
                            <th>上刊时间</th>
                            <th>下刊时间</th>
                            <th>操作人姓名</th>
                            <th>创建时间</th>
                            <th>编辑时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($preSaleList as $key => $val)
                        <?php //var_dump($val->customType);exit(); ?>
                        <tr>
                            <td><input type="checkbox" name="lineNum" value="{{$val->id}}"/></td>
                            <td>{{$val->trade_num}}</td>
                            <td>{{$val->equipment_num}}</td>
                            <td>
                                {{$val->province?$val->province->province:''}}
                                {{$val->city?$val->city->city_name:''}}
                                {{$val->area?$val->area->area:''}}
                            </td>
                            <td>{{$val->custom_type_id?$val->customType->custom_type:''}}</td>
                            <td>{{$val->custom?$val->custom->custom_name:''}}</td>
                            <td>{{$val->counts}}</td>
                            <td>{{date('Y-m-d',$val->start_time)}}</td>
                            <td>{{date('Y-m-d',$val->end_time)}}</td>
                            <td>{{$val->author->truename}}</td>
                            <td>{{$val->created_at}}</td>
                            <td class="center"> {{$val->updated_at}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{$preSaleList->links();}}
            <p style="float: right;">
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
        $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
        $('select').select2();
        $(":button[id='add']").click(function () {
            location.href = "/install/add";
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
                alert("请选择一个预售号");
                return false;
            } else {
                location.href = "{{URL::to('/media/add')}}?id=" + checks;
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
                location.href = "{{URL::to('/media/add')}}?act=show&id=" + checks;
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
