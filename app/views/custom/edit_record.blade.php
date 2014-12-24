@extends('layout.layout')
@section('css')
@parent
<link rel="stylesheet" href="/admin/css/bootstrap-wysihtml5.css" />
@stop
@section('content')
<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom">
            <i class="icon-home"></i> 控制面板</a>
        <a href="{{URL::to('/custom/index')}}" class="tip-bottom">销售管理</a>
        <a href="#" class="current">设置定期回访时间</a>
    </div>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>设置定期回访时间</h5>
                    @if (Session::has('flag'))
                    <span class="error">添加菜单失败，请重新添加！</span>
                    @endif
                </div>
                <div class="widget-content nopadding">
                    {{ Form::open(array('url' =>URL::to('/custom/editRecord'),'id'=>'addCustomRecord','class'=>'form-horizontal','method'=>'post','novalidate'=>'novalidate'))}}
                    <div class="control-group">
                        <label class="control-label">客户名称</label>
                        <div class="controls">
                            <label style="margin-top: 5px;">{{$custom->custom_name}}</label>
                            {{Form::hidden('id',$custom->id)}}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">客户状态</label>
                        <?php
                        $statusList = array(
                            ''  =>  '请选择',
                            '1' =>  '有意向',
                            '2' =>  '已报价',
                            '3' =>  '已签约',
                            '4' =>  '未联系',
                        );
                        ?>
                        <div class="controls" style="width: 250px;">
                            {{Form::select('status',$statusList,$custom->status,array('id'=>'status'))}}
                            {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">备注</label>

                        <div class="controls">
                            {{Form::textarea('remark','',array('id'=>'remark','class'=>'textarea_editor span8','row'=>'6','placeholder'=>'请输入……'));}}
                            {{ $errors->first('contacts', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">下次联系时间</label>

                        <div class="controls">
                            {{Form::text('next_visit_time','',array('placeholder'=>'下次联系时间','id'=>'next_visit_time','date-date-format'=>'yyyy-mm-dd','class'=>'datepicker'));}}
                            {{ $errors->first('next_visit_time', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="form-actions">
                        {{Form::submit('保存',array('id'=>'sub','class'=>'btn btn-success'));}}
                    </div>

                    {{Form::close()}}
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
<script type="text/javascript">
    $(document).ready(function(){

        $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
        $('select').select2();
        $('.textarea_editor').wysihtml5();
        // Form Validation
        $("#addCustomRecord").validate({
            rules:{
                remark:{
                    required:true
                },
                status:{
                    required:true
                },
                next_visit_time:{
                    required:true
                }
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

        $('.datepicker').datepicker();
    });
</script>
@stop
