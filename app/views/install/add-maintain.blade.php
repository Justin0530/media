@extends('layout.layout')
@section('css')
@parent
<link rel="stylesheet" href="/admin/css/bootstrap-wysihtml5.css" />

@stop
@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="/" class="tip-bottom">系统管理</a> <a href="{{URL::to('install/index')}}" class="current">渠道维护</a></div>
</div>
<div class="container-fluid">
    <hr>
    @if(!isset($kindergarten))<?php $kindergarten = new Kindergarten()?>@endif
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-content tab-content">
                    <?php
                    $maintain = [];
                    ?>
                    <div id="tab4" class="tab-pane active">
                        <div class="widget-content nopadding">
                            <form class="form-horizontal" method="post" action="{{URL::to('/install/maintain')}}" name="basic_validate" id="basic_validate" novalidate="novalidate">
                                {{Form::hidden('kid',$kid)}}
                                <div class="control-group">
                                    <label class="control-label">运动会是否接受赠品</label>
                                    <div class="controls">
                                        @if(!isset($maintain['gift'])||empty($maintain['gift']))<?php $maintain['gift'] = '2' ?> @endif
                                        <label>{{Form::radio('gift', '1', $maintain['gift']=='1'?true:false);}}是</label>
                                        <label>{{Form::radio('gift', '2', $maintain['gift']=='2'?true:false);}}否</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">是否有沟通难度</label>
                                    <div class="controls">
                                        @if(!isset($maintain['communication'])||empty($maintain['communication']))<?php $maintain['communication'] = '2' ?> @endif
                                        <label>{{Form::radio('communication', '1', $maintain['communication']=='1'?true:false);}}是</label>
                                        <label>{{Form::radio('communication', '2', $maintain['communication']=='2'?true:false);}}否</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">是否可以做活动</label>
                                    <div class="controls">
                                        @if(!isset($maintain['activies'])||empty($maintain['activies']))<?php $maintain['activies'] = '2' ?> @endif
                                        <label>{{Form::radio('activies', '1', $maintain['activies']=='1'?true:false);}}是</label>
                                        <label>{{Form::radio('activies', '2', $maintain['activies']=='2'?true:false);}}否</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">是否参与营销推广</label>
                                    <div class="controls">
                                        @if(!isset($maintain['promotion'])||empty($maintain['promotion']))<?php $maintain['promotion'] = '2' ?> @endif
                                        <label>{{Form::radio('promotion', '1', $maintain['promotion']=='1'?true:false);}}是</label>
                                        <label>{{Form::radio('promotion', '2', $maintain['promotion']=='2'?true:false);}}否</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">是否排斥英语培训广告</label>
                                    <div class="controls">
                                        @if(!isset($maintain['english_ad'])||empty($maintain['english_ad']))<?php $maintain['english_ad'] = '2' ?> @endif
                                        <label>{{Form::radio('english_ad', '1', $maintain['english_ad']=='1'?true:false);}}是</label>
                                        <label>{{Form::radio('english_ad', '2', $maintain['english_ad']=='2'?true:false);}}否</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">画面需要幼儿园审核</label>
                                    <div class="controls">
                                        @if(!isset($maintain['examine'])||empty($maintain['examine']))<?php $maintain['examine'] = '2' ?> @endif
                                        <label>{{Form::radio('examine', '1', $maintain['examine']=='1'?true:false);}}需要</label>
                                        <label>{{Form::radio('examine', '2', $maintain['examine']=='2'?true:false);}}不需要</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">幼儿园需要画面数量</label>
                                    <div class="controls" style="width: 150px;">
                                        {{Form::select('k_frame',array('0','1','2','3','4'))}}<b>&nbsp;副</b>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">广告画面数量</label>
                                    <div class="controls" style="width: 150px;">
                                        {{Form::select('ad_frame',array('1','2','3','4','5'))}}<b>&nbsp;副</b>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">维护人</label>
                                    <div class="controls" style="width: 250px;">
                                        {{Form::text('maintain_person',$maintain_person)}}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">备注s</label>
                                    <div class="controls">
                                        {{Form::textarea('remark','',array('id'=>'remark','class'=>'textarea_editor span8','rows'=>'5','placeholder'=>'请输入……'))}}
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
