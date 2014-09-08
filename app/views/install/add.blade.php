@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="/" class="tip-bottom">系统管理</a> <a href="{{URL::to('install/index')}}" class="current">点位管理</a></div>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>添加点位</h5>
                </div>
                <div class="widget-title">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab1">第一步</a></li>
                        <li><a data-toggle="tab" href="#tab2">第二步</a></li>
                        <li><a data-toggle="tab" href="#tab3">第三步</a></li>
                    </ul>
                </div>
                <div class="widget-content tab-content">
                    <div id="tab1" class="tab-pane active">
                        <p>And is full of waffle to It has multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end. </p>
                    </div>
                    <div id="tab2" class="tab-pane">
                        <p> waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end. </p>
                    </div>
                    <div id="tab3" class="tab-pane">
                        <p>full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end.multiple paragraphs and is full of waffle to pad out the comment. Usually, you just wish these sorts of comments would come to an end. </p>
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
