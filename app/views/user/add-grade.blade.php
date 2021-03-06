@extends('layout.layout')

@section('content')

<!--breadcrumbs-->

<!--End-breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a> <a href="#" class="tip-bottom">系统管理</a> <a href="#" class="current">级别管理</a> </div>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span6">
<div class="widget-box">
    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
        <h5>增加级别</h5>
    </div>
    <div class="widget-content nopadding">
        {{ Form::open(array('url' => URL::to('user/addGrade'),'id'=>'addGrade','class'=>'form-horizontal','method'=>'post','novalidate'=>'novalidate')) }}
            <div class="control-group">
                <label class="control-label">级别名称</label>
                <div class="controls">
                    {{Form::text('grade_name','',array('placeholder'=>'级别名称','class'=>'span11'));}}
                    {{ $errors->first('grade', '<span class="help-inline">:message</span>') }}
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">级别说明</label>
                <div class="controls">
                    {{Form::textarea('desc','',array('placeholder'=>'级别说明','class'=>'span11','rows'=>'0'));}}
                    {{ $errors->first('desc', '<span class="help-inline">:message</span>') }}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">权限范围</label>
                <div class="controls">
                    <label>
                        {{Form::radio('range', '1', true);}}全部
                    </label>
                    <label>
                        {{Form::radio('range', '2', false);}}筛选
                    </label>
                    {{ $errors->first('range', '<span class="help-inline">:message</span>') }}
                </div>
            </div>

            <div class="control-group" id="private" style="display: none">
                <label class="control-label">权限列表</label>
                <div class="controls">
                    @foreach($menu_list as $k1 => $v1)
                    <label>
                        <input type="checkbox" name="authority[]" value="{{$v1['id']}}" />{{$v1['menu']}}
                    </label>
                    @if(isset($v1['sub'])&&is_array($v1['sub']))
                        @foreach($v1['sub'] as $k2 => $v2)
                        <label>
                            <input type="checkbox" name="authority[]" value="{{$v2['id']}}" />——{{$v2['menu']}}
                        </label>
                            @if(isset($v2['sub'])&&is_array($v2['sub']))
                            @foreach($v2['sub'] as $k3 => $v3)
                                <label>
                                    <input type="checkbox" name="authority[]" value="{{$v3['id']}}" />————{{$v3['menu']}}
                                </label>
                            @endforeach
                            @endif
                        @endforeach
                    @endif
                    @endforeach
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#addGrade").validate({
            rules:{
                grade:{
                    required:true
                },
                desc:{
                    required:true
                },
                range:{
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

        $(":radio[name='range']").change(function() {
            //alert(this.value);
            if(this.value=='1'){
                $("#private").css('display','none');
            }
            if(this.value=='2'){
                $('#private').css('display','');
            }

        });

    });
</script>
@stop