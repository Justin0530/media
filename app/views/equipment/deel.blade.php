@extends('layout.layout')
@section('css')
@parent
<link rel="stylesheet" href="/admin/css/bootstrap-wysihtml5.css" />
@stop
@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="{{URL::action('EquipmentController@select')}}" class="current">运维管理</a><a href="javascript:void(0);" class="tip-bottom">上传实景图片</a> </div>
</div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>上传图片</h5>
                </div>
                <div class="widget-content tab-content">
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data" method="post" action="{{URL::action('EquipmentController@deelWith',[$frameID])}}" name="addPicture" id="addPicture" novalidate="novalidate">
                            <input type="hidden" name="eNum" value="{{$eNum}}" />
                            <div class="control-group">
                                <label class="control-label">图片</label>
                                <div class="controls">
                                    {{Form::file('image_path')}}
                                </div>
                            </div>

                            <div class="form-actions">
                                <input type="submit" value="开始上传" class="btn btn-success">
                            </div>
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
