@extends('layout.layout')
@section('css')
@parent
<link rel="stylesheet" href="/admin/css/bootstrap-wysihtml5.css" />

@stop
@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="/" class="tip-bottom">系统管理</a> <a href="{{URL::to('equipment/select')}}" class="current">运维管理</a></div>
</div>
<div class="container-fluid">
    <hr>
    @if(!isset($equipment))<?php $equipment = new Equipment()?>@endif
    <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-content nopadding">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>设备编号:<a href="/install/add?act=show&id={{$equipment->kid}}" target="_blank" title='点击查看详情'>{{$equipment->equipment_num}}</a></td>
                        <td>画面数量:{{isset($equipment->frames)?$equipment->frames:''}}</td>
                        <td>幼儿园名称:{{isset($equipment->kindergarten->name)?$equipment->kindergarten->name:''}}</td>
                        <td>区域:
                            {{isset($equipment->kindergarten->province->province)?$equipment->kindergarten->province->province:''}}
                            {{isset($equipment->kindergarten->city->city_name)?$equipment->kindergarten->city->city_name:''}}
                            {{isset($equipment->kindergarten->area->area)?$equipment->kindergarten->area->area:''}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="widget-box">
                <div class="widget-title">
                    <ul class="nav nav-tabs">

                        <li @if($step=="1")class="active"@endif><a data-toggle="tab" href="#tab1">预售画面</a></li>
                        <li @if($step=="2")class="active"@endif><a data-toggle="tab" href="#tab2">设备状态</a></li>
                        <li @if($step=="3")class="active"@endif><a data-toggle="tab" href="#tab3">巡查记录</a></li>
                        <li @if($step=="4")class="active"@endif><a data-toggle="tab" href="#tab4">全部巡查记录</a></li>
                    </ul>
                </div>
                <div class="widget-content tab-content">
                    <div id="tab1" class="tab-pane @if($step=='1') active @endif">
                        <label style="margin-bottom: -20px;">预售画面</label>
                        <hr>
                        <div class="widget-content">
                            <ul class="thumbnails">
                                @foreach($willFrames as $key => $val)

                                <li class="span1">
                                        <img src="{{$val->image_path}}" alt="" >
                                        <div class="actions">
                                            <a class="lightbox_trigger" href="{{$val->image_path}}">
                                                <i class="icon-search"></i>
                                            </a>
                                        </div>
                                    <span class="label">{{date('Y-m-d', $val->start_time)}}</span>
                                    <span class="label">{{date('Y-m-d', $val->end_time)}}</span>
                                    @if($val->status<1)
                                    <span class="label">
                                        <button class="btn-mini" style="width: 61px;" onclick="javascript:frame('{{$equipment->equipment_num}}','{{$val->id}}','2');">上刊</button>
                                    </span>
                                    @endif
                                </li>
                                @endforeach
                                <!--li class="span1"> <a> <img src="/admin/img/gallery/imgbox2.jpg" alt="" > </a>
                                    <div class="actions"><a class="lightbox_trigger" href="/admin/img/gallery/imgbox3.jpg"><i class="icon-search"></i></a> </div>
                                </li-->
                            </ul>
                        </div>
                        <label style="margin-top: 30px; margin-bottom: -20px;">当前画面</label>
                        <hr>
                        <div class="widget-content">
                            <ul class="thumbnails">
                                @foreach($nowFrames as $key => $val)
                                <li class="span1">
                                    <a> <img src="{{$val->image_path}}" alt="" > </a>
                                    <div class="actions">
                                        <a class="lightbox_trigger" href="{{$val->image_path}}"><i class="icon-search"></i></a>
                                    </div>
                                    <span class="label">{{$val->customType->custom_type}}</span>
                                    <span class="label">{{date('Y-m-d', $val->start_time)}}</span>
                                    <span class="label">{{date('Y-m-d', $val->end_time)}}</span>
                                    <span class="label">
                                        <button class="btn-mini" style="width: 61px;" onclick="javascript:frame('{{$equipment->equipment_num}}','{{$val->id}}','3');">下刊</button>
                                    </span>
                                </li>
                                @endforeach
                                <!--li class="span1">
                                    <a> <img src="/admin/img/gallery/imgbox1.jpg" alt="" > </a>
                                    <div class="actions">
                                        <a class="lightbox_trigger" href="/admin/img/gallery/imgbox3.jpg"><i class="icon-search"></i></a>
                                    </div>
                                    <span class="label">客户类型</span>
                                    <span class="label">上刊时间</span>
                                    <span class="label">下刊时间</span>
                                </li-->
                            </ul>
                        </div>
                    </div>

                    <div id="tab2" class="tab-pane @if($step=='2') active @endif">
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{URL::to('/equipment/manager/'.$equipment->id)}}" name="e2" id="e2" novalidate="novalidate">
                                {{Form::hidden('step','2');}}

                                <div class="control-group">
                                    <label class="control-label">LED状态</label>
                                    <div class="controls">
                                        <label>{{Form::radio('led_status', '1', $equipment->led_status=='1'?true:false)}}正常</label>
                                        <label>{{Form::radio('led_status', '2', $equipment->led_status=='2'?true:false)}}异常</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">LED状态备注</label>
                                    <div class="controls">
                                        {{Form::text('led_status_remark',$equipment->led_status_remark,array('id'=>'led_status_remark','placeholder'=>'备注'))}}
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">画面状态</label>
                                    <div class="controls">
                                        <label>{{Form::radio('frame_status', '1', $equipment->frame_status=='1'?true:false)}}正常</label>
                                        <label>{{Form::radio('frame_status', '2', $equipment->frame_status=='2'?true:false)}}不显示文字</label>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">画面状态备注</label>
                                    <div class="controls">
                                        {{Form::text('frame_status_remark',$equipment->frame_status_remark,array('id'=>'frame_status_remark','placeholder'=>'备注'))}}
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">灯箱电源</label>
                                    <div class="controls">
                                        <label>{{Form::radio('power_source_status', '1', $equipment->power_source_status=='1'?true:false)}}正常</label>
                                        <label>{{Form::radio('power_source_status', '2', $equipment->power_source_status=='2'?true:false)}}异常</label>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">灯箱电源备注</label>
                                    <div class="controls">
                                        {{Form::text('power_source_status_remark',$equipment->power_source_status_remark,array('id'=>'power_source_status_remark','placeholder'=>'备注'))}}
                                    </div>
                                </div>

                                @if(isset($act)&&$act=='show')
                                @else
                                <div class="form-actions">
                                    <input type="submit" value="保存" class="btn btn-success">
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <?php

                    ?>
                    <div id="tab3" class="tab-pane @if($step=='3') active @endif">
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" accept-charset="UTF-8" method="post" action="{{URL::to('/equipment/manager/'.$id)}}" name="addKindergartenContact" id="addKindergartenContact" novalidate="novalidate">
                                {{Form::hidden('pid','');}}
                                {{Form::hidden('step','3');}}
                                <div class="control-group">
                                    <label class="control-label">巡查人</label>
                                    <div class="controls">
                                        {{Form::text('patroler','',array('id'=>'patroler','placeholder'=>'巡查人'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">巡查时间</label>
                                    <div class="controls">
                                        {{Form::text('patrol_time','',array('id'=>'patrol_time','placeholder'=>'巡查时间','date-date-format'=>'yyyy-mm-dd','class'=>'datepicker'))}}
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">巡查内容</label>
                                    <div class="controls" style="width:250px;">
                                        <?php
                                        $patrolType = array(
                                            ''   => '请选择',
                                            '1'  => '上画',
                                            '2'  => '巡查',
                                            '3'  => '维修',
                                        );
                                        ?>
                                        {{Form::select('patrol_type',$patrolType,'',array('id'=>'patrol_time','placeholder'=>'巡查备注'))}}

                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">备注</label>
                                    <div class="controls">
                                        {{Form::textarea('remark','',array('placeholder'=>'巡查记录备注','class'=>'span11','rows'=>'0'));}}
                                    </div>
                                </div>

                                @if(isset($act)&&$act=='show')
                                @else
                                <div class="form-actions">
                                    <input type="submit" value="保存" class="btn btn-success">
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div id="tab4" class="tab-pane @if($step=='4') active @endif">
                        <div class="widget-content nopadding">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th >序号</th>
                                    <th>巡查人</th>
                                    <th>巡查类型</th>
                                    <th>巡查备注</th>
                                    <th>巡查时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patrolRecord as $key => $val)
                                <tr>
                                    <td>{{$val->id}}</td>
                                    <td>{{$val->patroler}}</td>
                                    <td>{{patrol_status($val->patrol_type)}}</td>
                                    <td>{{$val->remark}}</td>
                                    <td>{{date('Y-m-d', $val->patrol_time)}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$patrolRecord->links();}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
@parent
<script type="text/javascript" src="/admin/js/jquery.chained.js"></script>
<script type="text/javascript" src="/admin/js/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/admin/js/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="/admin/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
        $('select').select2();
        $('.datepicker').datepicker();
        $('.textarea_editor').wysihtml5();
        // Form Validation
        $("#addKindergarten").validate({
            rules:{
                name:{required:true },
                city_id:{required:true},
                region:{required:true},
                class_count:{required:true},
                children:{required:true},
                grade_id:{required:true},
                assessment_id:{required:true},
                tuition:{required:true}

            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });

    });

    function frame(e_num,frame_id,status)
    {
        if(!e_num||!frame_id||!status)
        {
            return false;
        }
        $.ajax({
             type: "POST",
             url: "/common/frame",
             dataType: "json",
             data:{equipment_num:e_num,frame_id:frame_id,status:status},
             success: function(data){
                 if(data)
                 {
                    alert(data);
                 }
                 else
                 {
                    window.location = "{{URL::action('EquipmentController@deelWith')}}?frameID="+frame_id+"&eNum="+e_num;
                 }
             }
         });
    }
</script>
@stop
