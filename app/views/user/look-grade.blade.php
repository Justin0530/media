@extends('layout.layout')

@section('content')

<!--breadcrumbs-->

<!--End-breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a> <a href="/" class="tip-bottom">系统管理</a> <a href="{{URL::to('user/grade')}}" class="current">级别管理</a> </div>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span">
<div class="widget-box">
    <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
        <h5>查看级别权限</h5>
    </div>
    <div class="widget-content">
    <div class="row-fluid">
    <div class="span12 btn-icon-pg">
    <ul>
    @foreach($grade_info->gradeMenu as $key => $val)
    <li><i class="icon-adjust"></i> {{$val->menu->menu}}</li>
    @endforeach
    </ul>
    </div>

    </div>

    </div>
</div>
            <p style="float: right;">
                <button id="reback" class="btn btn-success"><i class="icon-chevron-left"></i>  返回</button>

            </p>
            </div>
        </div>
    </div>
@stop
@section('js')
@parent
<script type="text/javascript">
    $(document).ready(function(){
        $(":button[id='reback']").click(function () {
            location.href = "/user/grade";
        });

    });
</script>
@stop