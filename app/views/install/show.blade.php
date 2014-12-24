@extends('layout.layout')
@section('css')
@parent
<link rel="stylesheet" href="/admin/css/bootstrap-wysihtml5.css" />

@stop
@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="/" class="tip-bottom">点位管理</a> <a href="{{URL::to('install/index')}}" class="current">点位信息</a></div>
</div>
<div class="container-fluid">
    <hr>
    @if(!isset($kindergarten))<?php $kindergarten = new Kindergarten()?>@endif
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>点位信息</h5>
                </div>
                <div class="widget-title">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab1">幼儿园信息</a></li>
                        <li><a data-toggle="tab" href="#tab2">联系人信息</a></li>
                        <li><a data-toggle="tab" href="#tab3">设备信息</a></li>
                    </ul>
                </div>
                <div class="widget-content tab-content">
                    <div id="tab1" class="tab-pane active">
                        @if(isset($flag)&&$flag=='successful')
                        <span>编辑成功</span>
                        @endif
                        @if(isset($flag)&&$flag=='error')
                        <span>编辑失败，请重新编辑</span>
                        @endif
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="" name="addKindergarten" id="addKindergarten" novalidate="novalidate">
                                {{Form::hidden('id',$kindergarten['id']);}}
                                {{Form::hidden('kid',$kindergarten['id']);}}
                                {{Form::hidden('step','1');}}
                                <div class="control-group">
                                    <label class="control-label">园区名称</label>
                                    <div class="controls">
                                        {{Form::text('name',$kindergarten['name'],array('id'=>'name'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" >类别</label>
                                    <div class="controls" style="width: 250px;">
                                        <?php $type = array('1'=>'公立','2'=>'私立'); ?>
                                        {{Form::select('type',$type,$kindergarten['type'],array('id'=>'type'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">幼儿园等级</label>
                                    <div class="controls" style="width: 250px;">
                                        {{Form::select('grade_id',$kindergartenGradeList,$kindergarten['grade_id'],array('id'=>'grade_id'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">公司评估等级</label>
                                    <div class="controls" style="width: 250px;">
                                        {{Form::select('assessment_id',$assessmentList,$kindergarten['assessment_id'],array('id'=>'assessment_id'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">媒体覆盖属性</label>
                                    <div class="controls" style="width: 250px;">
                                        {{Form::select('media_attr_id',$mediaAttrList,$kindergarten['media_attr_id'],array('id'=>'media_attr_id'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">幼儿园班数</label>
                                    <div class="controls">
                                        {{Form::text('class_count',$kindergarten['class_count'],array('id'=>'class_count'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">孩子数</label>
                                    <div class="controls">
                                        {{Form::text('children',$kindergarten['children'],array('id'=>'children'))}}
                                        {{ $errors->first('children', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">学费</label>
                                    <div class="controls">
                                        {{Form::text('tuition',$kindergarten['tuition'],array('id'=>'tuition'))}}
                                        {{ $errors->first('tuition', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">城市</label>
                                    <div class="controls" style="width: 250px;">
                                        {{Form::select('city_id',$cityList,$kindergarten['city_id'],array('id'=>'city_id'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">区域</label>
                                    <div class="controls">
                                        {{Form::text('region',$kindergarten['region'],array('id'=>'region'))}}
                                        {{ $errors->first('region', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">是否在社区内</label>
                                    <div class="controls">
                                        @if(!$kindergarten['in_community'])<?php $kindergarten['in_community']='1';?>@endif
                                        <label>
                                            {{Form::radio('in_community', '1', $kindergarten['in_community']=='1'?true:false)}}是
                                        </label>
                                        <label>
                                            {{Form::radio('in_community', '2', $kindergarten['in_community']=='2'?true:false)}}否
                                        </label>
                                        {{ $errors->first('in_community', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">社区名称</label>
                                    <div class="controls">
                                        {{Form::text('community_name',$kindergarten['community_name']);}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">是否沿街</label>
                                    <div class="controls">
                                        @if(!$kindergarten['is_along'])<?php $kindergarten['is_along']='1';?>@endif
                                        <label>
                                            {{Form::radio('is_along', '1', $kindergarten['is_along']=='1'?true:false);}}是
                                        </label>
                                        <label>
                                            {{Form::radio('is_along', '2', $kindergarten['is_along']=='2'?true:false);}}否
                                        </label>
                                        {{ $errors->first('is_along', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">正门所在马路</label>
                                    <div class="controls">
                                        {{Form::text('street',$kindergarten['street'],array('id'=>'street'));}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">幼儿园地址</label>
                                    <div class="controls">
                                        {{Form::text('address',$kindergarten['address'],array('id'=>'address'));}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">周边和环境描述</label>
                                    <div class="controls">
                                        {{Form::textarea('env_desc',$kindergarten['env_desc'],array('id'=>'env_desc','class'=>'textarea_editor span8','row'=>'6','placeholder'=>'请输入……'));}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">合同编号</label>
                                    <div class="controls">
                                        {{Form::text('pact_num',$kindergarten['pact_num'],array('id'=>'pact_num'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">签约年限</label>
                                    <div class="controls">
                                        {{Form::text('pact_year',$kindergarten['pact_year'],array('id'=>'pact_year'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">签约人</label>
                                    <div class="controls">
                                        {{Form::text('signatory',$kindergarten['signatory'],array('id'=>'signatory'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">签约时间</label>
                                    <div class="controls">
                                        {{Form::text('signing_time',$kindergarten['signing_time'],array('id'=>'signing_time','data-date-format'=>'yyyy-mm-dd','class'=>'datepicker span3'));}}
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <?php
                        $kindergarten_contact = $kindergarten->contacts->toArray();
                    ?>
                    @if(count($kindergarten_contact)<1)<?php $kindergarten_contact = new KindergartenContact()?>@endif
                    <div id="tab2" class="tab-pane">
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{URL::to('/install/add')}}" name="addKindergartenContact" id="addKindergartenContact" novalidate="novalidate">
                                {{Form::hidden('kid',$kindergarten['id'])}}
                                {{Form::hidden('step','2');}}
                                <?php $contact_type = array('1'=>'园长',2=>'老师',3=>'其它');?>
                                @foreach($contact_type as $key => $val)
                                <?php $k = $key -1;?>
                                <div class="control-group">
                                    <label class="control-label">{{$val}}称呼</label>
                                    <div class="controls">
                                        <input type="text" name="contact_name[]" id="contact_name" value="{{isset($kindergarten_contact[$k]['contact_name'])?$kindergarten_contact[$k]['contact_name']:''}}" placeholder="{{$val}}称呼">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{{$val}}QQ号码</label>
                                    <div class="controls">
                                        <input type="text" name="qq[]" value="{{isset($kindergarten_contact[$k]['qq'])?$kindergarten_contact[$k]['qq']:''}}"  id="qq" placeholder="{{$val}}QQ号码">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">{{$val}}电话</label>
                                    <div class="controls">
                                        <input type="text" name="mobile[]" value="{{isset($kindergarten_contact[$k]['mobile'])?$kindergarten_contact[$k]['mobile']:''}}"  id="mobile" placeholder="{{$val}}电话">
                                    </div>
                                </div>
                                @endforeach

                            </form>
                        </div>
                    </div>
                    <?php
                    $equipment = $kindergarten->equipment?$kindergarten->equipment->toArray():array();
                    ?>
                    @if(count($equipment)<1)<?php $equipment = new Equipment()?>@endif
                    <div id="tab3" class="tab-pane">
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data" method="post" action="{{URL::to('/install/add')}}" name="addKindergartenContact" id="addKindergartenContact" novalidate="novalidate">
                                {{Form::hidden('eid',$equipment['id']);}}
                                {{Form::hidden('kid',$kindergarten['id']);}}
                                {{Form::hidden('step','3');}}
                                <div class="control-group">
                                    <label class="control-label">设备编号</label>
                                    <div class="controls">
                                        {{Form::text('equipment_num',$equipment['equipment_num'],array('id'=>'equipment_num','placeholder'=>'设备编号'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">设备排序</label>
                                    <div class="controls">
                                        {{Form::text('equipment_sort',$equipment['equipment_sort'],array('id'=>'equipment_sort','placeholder'=>'设备排序'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">所处位置</label>
                                    <div class="controls" style="width: 250px;">
                                        {{Form::select('position_id',$position,$equipment['position_id'],array('id'=>'position_id'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">画面数量</label>
                                    <div class="controls">
                                        {{Form::text('frames',$equipment['frames'],array('id'=>'frames','placeholder'=>'画面数量'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">安装人员</label>
                                    <div class="controls">
                                        {{Form::text('erector',$equipment['erector'],array('id'=>'erector','placeholder'=>'安装人员'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">安装费用</label>
                                    <div class="controls">
                                        {{Form::text('installation_cost',$equipment['installation_cost'],array('id'=>'installation_cost','placeholder'=>'安装费用'))}}
                                    </div>
                                </div>
                                <div class="control-group" >
                                    <label class="control-label">设备状态</label>
                                    <div class="controls" style="width: 250px;">
                                        {{Form::select('equipment_status',$equipment_status_list,$equipment['equipment_status'],array('id'=>'equipment_status'))}}
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">完工图片</label>
                                    <div class="controls">
                                        {{Form::file('image_path')}}<br />
                                        @if($equipment['image_path'])
                                        <img src="{{$equipment['image_path']}}" width="200px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">完工时间</label>
                                    <div class="controls">
                                        {{Form::text('makespan',$equipment['makespan'],array('id'=>'makespan','placeholder'=>'完工时间','date-date-format'=>'yyyy-mm-dd','class'=>'datepicker'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">安装监理人</label>
                                    <div class="controls">
                                        {{Form::text('installation_supervisor',$equipment['installation_supervisor'],array('id'=>'installation_supervisor','placeholder'=>'安装监理人'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">施工监理人</label>
                                    <div class="controls">
                                        {{Form::text('construction_supervisor',$equipment['construction_supervisor'],array('id'=>'construction_supervisor','placeholder'=>'完工时间'))}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">备注</label>
                                    <div class="controls">
                                        {{Form::textarea('remark',$equipment['remark'],array('id'=>'remark','class'=>'textarea_editor span8','rows'=>'5','placeholder'=>'请输入……'));}}
                                    </div>
                                </div>
                            </form>
                        </div>
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
</script>
@stop
