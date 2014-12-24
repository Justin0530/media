@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="/" class="tip-bottom">运维管理</a> <a href="#" class="current">物料维护</a></div>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>添加菜单</h5>
                    @if (Session::has('flag'))
                    <span class="error">添加菜单失败，请重新添加！</span>
                    @endif
                </div>
                <div class="widget-content nopadding">
                    {{ Form::open(array('url' =>
                    URL::to('menu/add'),'id'=>'addMenu','class'=>'form-horizontal','method'=>'post','novalidate'=>'novalidate'))
                    }}
                    <div class="control-group">
                        <label class="control-label">菜单名称</label>

                        <div class="controls">
                            {{Form::text('menu','',array('placeholder'=>'菜单名称'));}}
                            {{ $errors->first('menu', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">菜单URL</label>

                        <div class="controls">
                            {{Form::text('menu_url','',array('placeholder'=>'菜单URL'));}}
                            {{ $errors->first('menu_url', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">父级菜单</label>

                        <div class="controls" style="width: 267px;">
                            <select id="parent_id" name="parent_id">
                                @foreach($tree as $key => $val)
                                <option value="{{$val['menu_grade'].'-'.$val['id']}}"><stroage>{{$val['menu']}}</stroage></option>
                                @if(isset($val['sub'])&&is_array($val['sub']))
                                @foreach($val['sub'] as $k => $v)
                                <option value="{{$v['menu_grade'].'-'.$v['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$v['menu']}}</option>
                                @endforeach
                                @endif
                                @endforeach
                            </select>
                            {{ $errors->first('grade', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label">状态</label>

                        <div class="controls">
                            <label>
                                {{Form::radio('status','1',true);}}启用
                            </label>
                            <label>
                                {{Form::radio('status','0',false);}}禁用
                            </label>
                            {{ $errors->first('status', '<span class="help-inline">:message</span>') }}
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
<script type="text/javascript">
    $(document).ready(function(){

        $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
        // Form Validation
        $("#addMenu").validate({
            rules:{
                menu:{
                    required:true
                },
                status:{
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
    });
</script>
@stop
