@extends('layout.layout')

@section('content')

<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a></div>
</div>
<!--End-breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a> <a href="#" class="tip-bottom">系统管理</a> <a href="#" class="current">级别管理</a> </div>
    <h1>增加级别</h1>
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
        {{ Form::open(array('url' => URL::to('grade'),'id'=>'addGrade','class'=>'form-horizontal','method'=>'post','novalidate'=>'novalidate')) }}
            <div class="control-group">
                <label class="control-label">级别名称</label>
                <div class="controls">
                    {{Form::text('grade','',array('placeholder'=>'级别名称','class'=>'span11'));}}
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Checkboxes</label>
                <div class="controls">
                    <label>
                        <input type="checkbox" name="radios" />
                        First One</label>
                    <label>
                        <input type="checkbox" name="radios" />
                        Second One</label>
                    <label>
                        <input type="checkbox" name="radios" />
                        Third One</label>
                </div>
            </div>


            <div class="form-actions">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        {{Form::close()}}
    </div>
</div>
            </div>
        </div>
    </div>
@stop
