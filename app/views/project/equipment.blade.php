@extends('layout.layout')
@section('css')
@parent
<link rel="stylesheet" href="/admin/css/bootstrap-wysihtml5.css" />

@stop
@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="/" class="tip-bottom">工程管理</a> <a href="{{URL::to('install/index')}}" class="current">确认设备安装</a></div>
</div>
<div class="container-fluid">

    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-list"></i> </span>
                    <h5>点位信息</h5>
                </div>
                <div class="widget-content">
                    <table class="table table-bordered table-invoice-full">
                        <tbody>
                            <tr>
                                <td>点位编号:{{$kindergarten->id}}</td>
                                <td>幼儿园名称:{{$kindergarten->name}}</td>
                                <td>省/直辖市:{{isset($kindergarten->province->province)?$kindergarten->province->province:'--'}}</td>
                                <td>城市:{{isset($kindergarten->city->city_name)?$kindergarten->city->city_name:''}}</td>
                                <td>区/县{{isset($kindergarten->area->area)?$kindergarten->area->area:''}}</td>
                            </tr>
                            <tr>
                                <td colspan="5">地址:
                                @if($kindergarten->region) {{'('.$kindergarten->region.')'}} @endif {{$kindergarten->address}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-list"></i> </span>
                    <h5>设备信息</h5>
                </div>
                <div class="widget-content tab-content">
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data" method="post" action="/project/save?kid={{$kid}}" name="addKindergartenContact" id="addKindergartenContact" novalidate="novalidate">
                            {{Form::hidden('id',$equipment['id']);}}
                            {{Form::hidden('kid',$kindergarten['id']);}}
                            <div class="control-group">
                                <label class="control-label">设备编号</label>
                                <div class="controls">
                                    {{Form::text('equipment_num',$equipment['equipment_num'],array('id'=>'equipment_num','placeholder'=>'设备编号'))}}
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
                            <div class="control-group" >
                                <label class="control-label">安装方式</label>
                                <div class="controls" style="width: 250px;">
                                    {{Form::select('install_method',$install_method_list,$equipment['install_method'],array('id'=>'install_method'))}}
                                </div>
                            </div>

                            <div class="control-group" >
                                <label class="control-label">设备状态</label>
                                <div class="controls" style="width: 250px;">
                                    {{Form::select('equipment_status',$equipment_status_list,$equipment['equipment_status'],array('id'=>'equipment_status'))}}
                                </div>
                            </div>
                            <div id="reason_div" class="control-group" >
                                <label class="control-label">原因</label>
                                <div class="controls">
                                    <?php
                                        if($equipment['reason'])
                                        {
                                            $reason = explode('|',$equipment['reason']);
                                        }
                                        else
                                        {
                                            $reason = [];
                                        }

                                    ?>
                                    {{Form::checkbox('reason[]','城管物业',in_array('城管物业',$reason)?TRUE:FALSE),'城管物业'}}
                                    {{Form::checkbox('reason[]','安装条件',in_array('安装条件',$reason)?TRUE:FALSE),'安装条件'}}
                                    {{Form::checkbox('reason[]','沟通渠道',in_array('沟通渠道',$reason)?TRUE:FALSE),'沟通渠道'}}
                                    {{Form::checkbox('reason[]','主动放弃',in_array('主动放弃',$reason)?TRUE:FALSE),'主动放弃'}}
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
                                    {{Form::text('construction_supervisor',$equipment['construction_supervisor'],array('id'=>'construction_supervisor','placeholder'=>'施工监理人'))}}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">备注</label>
                                <div class="controls">
                                    {{Form::textarea('remark',$equipment['remark'],array('id'=>'remark','class'=>'textarea_editor span8','rows'=>'5','placeholder'=>'请输入……'));}}
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
@stop
@section('js')
@parent
<script type="text/javascript" src="/admin/js/jquery.chained.js"></script>
<script type="text/javascript" src="/admin/js/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="/admin/js/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="/admin/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        if($("#equipment_status").val()=='1')
        {
            $("#reason_div").css('display','');
        }
        else
        {
            $("#reason_div").css('display','none');
        }
        $("#equipment_status").click(function(){
            if(this.value=='1')
            {
                $("#reason_div").css('display','');
            }
            else
            {
                $("#reason_div").css('display','none');
            }
        });

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
