@extends('layout.layout')
@section('css')
@parent
<link rel="stylesheet" href="/admin/css/bootstrap-wysihtml5.css" />
@stop
@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="{{URL::to('/media/index')}}" class="current">媒体管理</a><a href="{{URL::to('/media/add')}}" class="tip-bottom">预售点位</a> </div>
</div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>预售点位</h5>
                </div>
                <div class="widget-content tab-content">
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data" method="post" action="{{URL::to('/media/add')}}" name="addMedia" id="addKindergartenContact" novalidate="novalidate">
                            {{Form::hidden('id',$preSale->id)}}
                            <div class="control-group">
                                <label class="control-label">客户名称</label>
                                <div class="controls" style="width: 250px;">
                                    {{Form::select('custom_id',array(''=>'请选择')+$customList,$preSale->custom_id,array('id'=>'custom_id'))}}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">预售类型</label>
                                <div class="controls" style="width: 250px;">
                                    {{Form::select('custom_type_id',array(''=>'请选择')+$customTypeList,$preSale->custom_type_id,array('id'=>'custom_id'))}}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">城市名称</label>
                                <div class="controls">
                                   <span class="span2">{{Form::select('province_id',array('0'=>'省/直辖市')+$provinceList,$preSale->province_id,array('id'=>'province_id','onclick'=>'regionalData(this,"city_id","City")'))}}</span>
                                   <span class="span2">{{Form::select('city_id',array('0'=>'请选择'),$preSale->city_id,array('id'=>'city_id','onclick'=>'regionalData(this,"area_id","Area")'))}}</span>
                                   <span class="span2">{{Form::select('area_id',array('请选择'),$preSale->area_id,array('id'=>'area_id'))}}</span>
                                   {{Form::hidden('tmp_city_id',$preSale->city_id,array('id'=>'tmp_city_id'))}}
                                   {{Form::hidden('tmp_area_id',$preSale->area_id,array('id'=>'tmp_area_id'))}}
                                </div>
                            </div>
                            <!--div class="control-group">
                                <label class="control-label">点位</label>
                                <div class="controls" style="width: 250px;">
                                    {{Form::select('equipment_num',array(''=>'请选择')+$equipmentList,$preSale->equipment_num,array('id'=>'equipment_num'))}}
                                </div>
                            </div-->
                            <?php
                                $eArr = [];
                                $eArr = explode(',',$preSale->equipment_num);
                            ?>
                            <div class="control-group">
                                <label class="control-label">点位</label>
                                <div class="controls" id="equipment_num_div">
                                    @foreach($equipmentList as $key  => $val)
                                    {{Form::checkbox('equipment_num[]', $val,in_array($val,$eArr)?true:false ),$val}}
                                    @endforeach
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">上刊时间</label>
                                <div class="controls">
                                    {{Form::text('start_time',$preSale->start_time?date('Y-m-d',$preSale->start_time):'',array('id'=>'start_time','placeholder'=>'上刊时间','date-date-format'=>'yyyy-mm-dd','class'=>'datepicker'))}}
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">下刊时间</label>
                                <div class="controls">
                                    {{Form::text('end_time',$preSale->end_time?date('Y-m-d',$preSale->end_time):'',array('id'=>'end_time','placeholder'=>'下刊时间','date-date-format'=>'yyyy-mm-dd','class'=>'datepicker'))}}
                                </div>
                            </div>
                            @if($preSale->frames&&$preSale->id&&count($preSale->frames))

                            @foreach($preSale->frames as $key => $val)
                            <div class="control-group">
                                <label class="control-label">预售图片</label>
                                <div class="controls">
                                    @if($val->image_path)
                                    <image width="80px" src="{{$val->image_path}}" />
                                    @endif
                                    {{Form::file('image_path[]')}}
                                    {{Form::hidden('image_path_id[]',$val->id)}}
                                    @if(!$key)
                                    <input type="button" name="addImage" id="addImage" value="添加图片" class="btn btn-info">
                                    <input type="button" name="removeImage" id="removeImage" value="删除图片" class="btn btn-info">
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="control-group">
                                <label class="control-label">预售图片</label>
                                <div class="controls">
                                    {{Form::file('image_path[]')}}
                                    {{Form::hidden('image_path_id[]')}}
                                    <input type="button" name="addImage" id="addImage" value="添加图片" class="btn btn-info">
                                    <input type="button" name="removeImage" id="removeImage" value="删除图片" class="btn btn-info">
                                </div>
                            </div>
                            @endif
                            @if(!isset($act) || $act!='show')
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
<script type="text/javascript" src="/admin/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').datepicker();
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

        str = '<div class="control-group"><label class="control-label">预售图片</label><div class="controls">{{Form::hidden('image_path_id[]')}}{{Form::file("image_path[]")}}</div></div>'

        $("#addImage").click(function(){
            $(".control-group:last").after(str);
            $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
        });
        $("#removeImage").click(
            function(){
                if($("input[type='file']").length>1)
                {
                    $('.control-group').last().remove();
                }
                else
                {
                    alert('已经是最后一个了，不能再删了');
                }

            }
        );
        $("#area_id").click(function(){
            getEidInfo();
        });

    });

    function getEidInfo()
    {
        province_id = $("#province_id").val();
        city_id = $("#city_id").val();
        area_id = $("#area_id").val();
        $.ajax({
            url:'/common/einfo',// 跳转到 action
            data:{
                province_id:province_id,
                city_id:city_id,
                area_id:area_id
            },
            type:'post',
            cache:false,
            dataType:'json',
            success:function(data) {
                if(data){
                    var html = '';
                    var len = data.length;
                    for(i=0;i<len;i++)
                    {
                        html += '<input name="equipment_num[]" type="checkbox" value="'+data[i]+'">'+data[i];
                    }
                    $("#equipment_num_div").html(html);
                    $('input[type=checkbox]').uniform();
                }else{
                    $("#equipment_num_div").html('');
                }
             },
             error : function() {
                  alert("网络异常！");
             }
        });
    }
</script>
@stop
