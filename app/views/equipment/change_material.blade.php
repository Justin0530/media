@extends('layout.layout')
@section('content')
<!-- PAGE CONTENT BEGINS -->

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">运维管理</a> <a href="#" class="current">物料管理</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<br>
<div class="container-fluid">
{{Form::open(array('url' => '/material/index','method'=>'get'))}}
    <span class="span" style="margin-left: 10px;margin-right: 15px;">{{Form::text('name',isset($keyword)?$keyword:'',array('id'=>'keyword','placeholder'=>'关键字'))}}</span>
    <span class="span2">
        {{Form::select('province_id',array('0'=>'请选择省/直辖市')+$provinceList,$province_id,array('id'=>'province_id','placeholder'=>'省/直辖市'))}}
    </span>
    <span class="span2">
        @if($city_id)
            {{Form::select('city_id',array('0'=>'请选择城市')+$cityList,$city_id,array('id'=>'city_id','placeholder'=>'城市名称'))}}
        @else
            {{Form::select('city_id',array('0'=>'请选择城市'),$city_id,array('id'=>'city_id','placeholder'=>'城市名称'))}}
        @endif
    </span>
    <span class="span2" style="margin-left: 10px;"><input type="submit" value="查询" class="btn btn-success"></span>
{{Form::close()}}
<hr>
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">

            <div class="widget-content nopadding">
                <table class="table table-bordered table-striped with-check">
                    <thead>
                    <tr>
                       <th>
                       <div class="checker" id="uniform-title-table-checkbox">
                           <span class="">
                               <input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" style="opacity: 0;">
                           </span>
                       </div>
                       </th>
                       <th>编号</th>
                       <th>省/直辖市</th>
                       <th>城市</th>
                       <th>物料分类</th>
                       <th>物料名称</th>
                       <th>总数</th>
                       <th>好的数量</th>
                       <th>坏的数量</th>
                       <th>添加日期</th>
                       <th>修改日期</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $value)
                    <tr>
                       <td>
                       <div class="checker" id="uniform-undefined">
                           <span class="">
                              <input type="checkbox" name="lineNum" value="{{$value->id}}" style="opacity: 0;">
                           </span>
                       </div>
                       </td>
                       <td>{{$value['id']}}</td>
                       <td>{{$value->province->province}}</td>
                       <td>{{$value->city_id?$value->city->city_name:''}}</td>
                       <td>{{$value->material_cat_id?$value->materialCat->material_cat:''}}</td>
                       <td>{{$value->name}}</td>
                       <td>{{$value->total_num}}</td>
                       <td>{{$value->num}}</td>
                       <td>{{$value->error_num}}</td>
                       <td>{{$value->created_at}}</td>
                       <td>{{$value->updated_at}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- /widget-main -->
            </div>
            <!-- /widget-body -->
		</div>
        {{$data->links();}}
		<p style="float: right;">
            <button id="apply" class="btn btn-success"><i class="icon-upload"></i></i>  使用</button>
        </p>
	</div>
</div>
</div>
@stop


@section('js')
@parent
<script>
    $(function () {


        $(":button[id='apply']").click(function () {
            var checks = "";
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                }
            });
            checks = checks.substr(0, checks.length - 1);

            if ($.trim(checks) == '') {
                alert("请选择一个条目");
                return false;
            } else {
                var num = prompt("请输入使用数量","1")
                if (confirm('您确认要使用'+num+'件吗？')) {
                    $.post("/equipment/changeMaterialAjax/" + checks,
                        {eid:'{{$kid}}',num:num},
                        function (data) {
                            if (data=='10000') {
                                //location.href="/equipment/manager/{{$kid}}?step=2";
                            }else if(data=='10002') {
                                alert('物料不足，请联系上级采购或进行调拨！');
                            }else{
                                alert('系统异常，请稍后重试');
                            }
                        }
                    );
                }
            }
        });
    });
</script>
@stop