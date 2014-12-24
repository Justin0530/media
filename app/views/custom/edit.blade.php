@extends('layout.layout')
@section('content')
<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> 控制面板</a>
        <a href="{{URL::to('/custom/index')}}" class="tip-bottom">销售管理</a>
        <a href="#" class="current">添加客户信息</a>
    </div>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>添加客户信息</h5>
                    @if (Session::has('flag'))
                    <span class="error">添加菜单失败，请重新添加！</span>
                    @endif
                </div>
                <div class="widget-content nopadding">
                    {{ Form::open(array('url' =>
                    URL::to('/custom/edit'),'id'=>'addCustom','class'=>'form-horizontal','method'=>'post','novalidate'=>'novalidate'))
                    }}
                    {{Form::hidden('id',$id)}}
                    <div class="control-group">
                        <label class="control-label">客户名称</label>
                        <div class="controls">
                            {{Form::text('custom_name',$custom_name,array('placeholder'=>'客户名称'));}}
                            {{ $errors->first('custom_name', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">客户属性</label>
                        <?php
                            $attrList = array(
                                ''  => '请选择',
                                '1' =>  '直客',
                                '2' =>  '4A广告公司'
                            );
                        ?>
                        <div class="controls" style="width: 250px;">
                            {{Form::select('attr',$attrList,$attr,array('id'=>'attr'))}}
                            {{ $errors->first('attr', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">联系人名称</label>

                        <div class="controls">
                            {{Form::text('contacts',$contacts,array('placeholder'=>'联系人名称','id'=>'contacts'));}}
                            {{ $errors->first('contacts', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">联系人职位</label>

                        <div class="controls">
                            {{Form::text('place',$place,array('placeholder'=>'联系人职位','id'=>'place'));}}
                            {{ $errors->first('contacts', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">手机</label>

                        <div class="controls">
                            {{Form::text('mobile',$mobile,array('placeholder'=>'联系人手机','id'=>'mobile'));}}
                            {{ $errors->first('mobile', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">固话</label>

                        <div class="controls">
                            {{Form::text('telephone',$telephone,array('placeholder'=>'联系人固话','id'=>'telephone'));}}
                            {{ $errors->first('telephone', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email</label>

                        <div class="controls">
                            {{Form::text('email',$email,array('placeholder'=>'联系人Email','id'=>'email'));}}
                            {{ $errors->first('menu_url', '<span class="help-inline">:message</span>') }}
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
                            {{Form::select('status',$statusList,$status,array('id'=>'status'))}}
                            {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">下次联系时间</label>

                        <div class="controls">
                            {{Form::text('next_visit_time',$next_visit_time?date('Y-m-d',$next_visit_time):'',array('placeholder'=>'下次联系时间','id'=>'next_visit_time','date-date-format'=>'yyyy-mm-dd','class'=>'datepicker'));}}
                            {{ $errors->first('menu_url', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    @if(!$act)
                    <div class="form-actions">
                        {{Form::submit('保存',array('id'=>'sub','class'=>'btn btn-success'));}}
                    </div>
                    @endif
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
<script type="text/javascript">
    $(document).ready(function(){

        $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
        $('select').select2();
        // Form Validation
        $("#addCustom").validate({
            rules:{
                custom_name:{
                    required:true
                },
                attr:{
                    required:true
                },
                contacts:{
                    required:true
                },
                mobile:{
                    required:true
                },
                telephone:{
                    required:true
                },
                email:{
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
        $("#parent_id").select2({
            placeholder: "请选择"
        });
        $('.datepicker').datepicker();
    });

</script>
@stop
