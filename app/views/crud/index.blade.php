@extends('layout.layout')
@section('content')
<!-- PAGE CONTENT BEGINS -->

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">{{isset($config['parent_title'])?$config['parent_title']:"系统管理"}}</a> <a href="#" class="current">{{$config['title']}}</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<br>
<div class="container-fluid">
{{Form::open(array('url' => URL::to($config['router']).'?'.Request::getQueryString(),'method'=>'get'))}}
    <div>
        <span class="span" style="margin-left: 10px;margin-right: 15px;">{{Form::text('name',isset($keyword)?$keyword:'',array('id'=>'keyword','placeholder'=>'关键字'))}}</span>
        <span class="span2" style="margin-left: 10px;"><input type="submit" value="查询" class="btn btn-success"></span>
    </div>
{{Form::close()}}
<hr>
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
			<div class="widget-title">
			    <span class="icon">
                     <i class="icon-th"></i>
                </span>
				<h5>{{$config['title']}}</h5>
			</div>
            <div class="widget-content nopadding">
                <table class="table table-bordered table-striped with-check">
                    <thead>
                    <tr>
                        @foreach($config['items'] as $key=>$item)
                        @if(!isset($item['hidden'])||$item['hidden']!==true)
                        <td style="min-width: 80px;">{{$item['title']}}</td>
                        @endif
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $value)
                    <tr>
                        @foreach($config['items'] as $key=>$item)
                        @if(!isset($item['hidden'])||$item['hidden']!==true)
                        @if($item['type']=='image')
                        <td>
                            @if($value[$key])
                            <img src="http://baicheng-cms.qiniudn.com/{{$value[$key]}}-w36" alt=""/>
                            @endif
                        </td>
                        @elseif($item['type']=='select')
                        <td>{{$item['select-items'][$value[$key]]}}</td>
                        @elseif($key=="id")
                        <td><input type="checkbox" name="lineNum" value="{{$value[$key]}}"/>{{$value[$key]}}</td>
                        @else
                        <td>{{$value[$key]}}</td>
                        @endif
                        @endif
                        @endforeach

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
            <button id="add" class="btn btn-success"><i class="icon-plus"></i></i>  增加</button>
            <button id="edit" class="btn btn-success"><i class="icon-edit"></i></i>  编辑</button>
            <button id="del" class="btn btn-success"><i class="icon-remove"></i></i>  删除</button>
            <button id="look" class="btn btn-success"><i class="icon-eye-open"></i></i>  查看</button>
        </p>
	</div>
</div>
</div>
@stop


@section('js')
@parent
<script>
    $(function () {
        $('input[type=checkbox],input[type=radio],input[type=file]').uniform();
        $('select').select2();
        $(":button[id='add']").click(function () {
            location.href = "{{$config['router']}}/create?{{Request::getQueryString()}}";
        });

        $(":button[id='edit']").click(function () {
            var checks = "";
            var num = 0;
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                    num ++;
                }
            });
            checks = checks.substr(0, checks.length - 1);
            if ($.trim(checks) == ''||num>1) {
                alert("请选择一个条目");
                return false;
            } else {
                location.href = "{{ URL::to($config['router'].'/')}}/"+checks+"/edit?{{Request::getQueryString()}}";
            }
        });

        $(":button[id='look']").click(function () {
            var checks = "";
            var num = 0;
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                    num ++;
                }
            });
            checks = checks.substr(0, checks.length - 1);
            if ($.trim(checks) == ''||num>1) {
                alert("请选择一个条目");
                return false;
            } else {
                location.href = "{{ URL::to($config['router'].'/') }}?{{Request::getQueryString()}}?act=show&id=" + checks;
            }
        });

        $(":button[id='del']").click(function () {
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
                if (confirm('真的删除该条目吗?')) {
                    $.post("{{ URL::to($config['router'].'/') }}/" + checks,
                        {_method:'DELETE'},
                        function (data) {
                            if (data) {
                                alert('删除成功！');
                            } else {
                                alert('删除失败！');
                            }
                            parent.location.reload();
                        }
                    );
                }
            }
        });
    });
</script>
@stop