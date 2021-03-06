@extends('layout.layout')

@section('content')

<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
    </div>
</div>
<!--End-breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">系统管理</a> <a href="#" class="current">用户管理</a></div>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>编辑用户{{$user->truename}}</h5>
                    @if (Session::has('flag'))
                    <span class="error">编辑用户失败，请重新编辑！</span>
                    @endif
                </div>
                <div class="widget-content nopadding">
                    {{ Form::open(array('url' =>
                    URL::to('user/edit/'.$user->id),'id'=>'editUser','class'=>'form-horizontal','method'=>'post','novalidate'=>'novalidate'))
                    }}
                    <div class="control-group">
                        <label class="control-label">真实姓名</label>

                        <div class="controls">
                            {{ Form::text('title', $user->truename) }}
                            {{ $errors->first('truename', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">联系电话</label>

                        <div class="controls">
                            <input type="text" name="mobile" value="{{$user->mobile}}" id="mobile">
                            {{ $errors->first('mobile', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">邮箱</label>

                        <div class="controls">
                            <input type="text" name="email" value="{{$user->email}}" id="email">
                            {{ $errors->first('email', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">级别</label>

                        <div class="controls" style="width: 267px;">
                            {{Form::select('grade', $gradeList,$user->grade_id);}}
                            {{ $errors->first('grade', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">密码</label>

                        <div class="controls">
                            {{Form::text('password','',array('placeholder'=>'登陆密码'));}}
                            {{ $errors->first('password', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">是否在职</label>

                        <div class="controls">
                            <label>
                                {{Form::radio('resignation','1',true);}}在职
                            </label>
                            <label>
                                {{Form::radio('resignation','0',false);}}离职
                            </label>
                            {{ $errors->first('resignation', '<span class="help-inline">:message</span>') }}
                        </div>
                    </div>


                    <div class="form-actions">
                        {{Form::token()}}
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

        $('input[type=checkbox],input[type=radio],input[type=file]').uniform();

        $('select').select2();

        // Form Validation
        $("#editUser").validate({
            rules:{
                required:{
                    required:true
                },
                email:{
                    required:true,
                    email: true
                },
                truename:{
                    required:true
                },
                mobile:{
                    required:true,
                    number:true
                },
                grade:{
                    required:true
                },
                resignation:{
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

    });
</script>
@stop
