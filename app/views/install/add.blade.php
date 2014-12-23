@extends('layout.layout')
@section('css')
@parent
<link rel="stylesheet" href="/admin/css/bootstrap-wysihtml5.css" />

@stop
@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="{{URL::action('InstallController@index')}}" class="tip-bottom">点位管理</a> <a href="{{URL::to('install/index')}}" class="current">点位编辑</a></div>
</div>
<div class="container-fluid">
    @if(!isset($kindergarten))<?php $kindergarten = new Kindergarten()?>@endif
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">

                <div class="widget-title">
                    <ul class="nav nav-tabs">
                        <li @if($step=="1")class="active"@endif><a data-toggle="tab" href="#tab1">第一步 编辑幼儿园信息</a></li>
                        <li @if($step=="2")class="active"@endif><a data-toggle="tab" href="#tab2">第二步 编辑联系人信息</a></li>
                    </ul>
                </div>
                <div class="widget-content tab-content">
                    <div id="tab1" class="tab-pane @if($step=='1') active @endif">
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
                                        {{Form::text('tuition',$kindergarten['tuition'],array('id'=>'tuition'))}}/月
                                        {{ $errors->first('tuition', '<span class="help-inline">:message</span>') }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">城市</label>
                                    <div class="controls" >
                                        <span class="span2">{{Form::select('province_id',$provinceList,$kindergarten['province_id'],array('id'=>'province_id','onclick'=>'regionalData(this,"city_id","City")'))}}</span>
                                        <span class="span2">{{Form::select('city_id',$cityList,$kindergarten['city_id'],array('id'=>'city_id','onclick'=>'regionalData(this,"area_id","Area")'))}}</span>
                                        <span class="span2">{{Form::select('area_id',$areaList,$kindergarten['area_id'],array('id'=>'area_id'))}}</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">区域(商圈)</label>
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
                                <div class="control-group" id="pact_num_div">
                                    <label class="control-label">合同号</label>
                                    <div class="controls">
                                        {{Form::text('pact_num',$kindergarten['pact_num'],array('id'=>'pact_num'))}}
                                    </div>
                                </div>
                                <div class="control-group" id="pace_year_div">
                                    <label class="control-label">合同年限</label>
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
                        $kindergarten_contact = $kindergarten->contacts->toArray();
                    ?>
                    @if(count($kindergarten_contact)<1)<?php $kindergarten_contact = new KindergartenContact()?>@endif
                    <div id="tab2" class="tab-pane @if($step=='2') active @endif">
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

                                @if(isset($act)&&$act=='show')
                                @else
                                <div class="form-actions">
                                    <input type="submit" value="保存" class="btn btn-success">
                                </div>
                                @endif
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
