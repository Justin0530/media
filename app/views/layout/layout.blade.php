<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{isset($title)?$title:'控制面板'}}————玺越传媒</title>
    <meta charset="UTF-8" />
    @section('css')
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/admin/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/admin/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="/admin/css/uniform.css" />
    <link rel="stylesheet" href="/admin/css/select2.css" />
    <link rel="stylesheet" href="/admin/css/matrix-style.css" />
    <link rel="stylesheet" href="/admin/css/matrix-media.css" />
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="/admin/css/jquery.gritter.css" />
    <link href='/admin/css/font-face.css' rel='stylesheet' type='text/css'>


    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="/css/jquery.fileupload.css">
    <link rel="stylesheet" href="/css/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="/css/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="/css/jquery.fileupload-ui-noscript.css"></noscript>
    @show
</head>
<body>

<!--Header-part-->
<div id="header">
    <h1><a href="{{URL::to('/')}}">玺越传媒</a></h1>
</div>
<!--close-Header-part-->

@section('menu')
<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav">
        <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">欢迎您</span><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#"><i class="icon-user"></i>个人信息</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="icon-check"></i>我的任务</a></li>
                <li class="divider"></li>
                <li><a href="{{URL::to('logout')}}"><i class="icon-key"></i>注销</a></li>
            </ul>
        </li>
        <!--<li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">消息</span> <span class="label label-important">5</span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i>写消息</a></li>
                <li class="divider"></li>
                <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i>收件箱</a></li>
                <li class="divider"></li>
                <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i>发件箱</a></li>
                <li class="divider"></li>
                <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i>垃圾箱</a></li>
            </ul>
        </li>-->
        <li class=""><a title="" href="{{URL::to('menu/index')}}"><i class="icon icon-cog"></i> <span class="text">设置</span></a></li>
        <li class=""><a title="" href="{{URL::to('logout')}}"><i class="icon icon-share-alt"></i> <span class="text">注销</span></a></li>
    </ul>
</div>
<!--close-top-Header-menu-->

<!--start-top-serch-->
<div id="search">
    <input type="text" placeholder="搜索在这里..."/>
    <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-serch-->
@show
@section('sidebar')
<!--sidebar-menu-->
<?php
$menu = Session::get('menu');
$parent_menu_id = Session::get('parent_menu_id');
$sub_menu_id = Session::get('sub_menu_id');
$icon = array(
    'icon icon-signal',
    'icon icon-fire',
    'icon icon-inbox',
    'icon icon-fullscreen',
    'icon icon-th-list',
    'icon icon-user-md',
    'icon icon-tint',
);
?>

<div id="sidebar">
    <a href="{{URL::to('/')}}" class="visible-phone"><i class="icon icon-home"></i> 控制面板</a>
    <ul>
        <li class="@if(!$parent_menu_id)active@endif"><a href="/"><i class="icon icon-home"></i> <span>控制面板</span></a> </li>
        @foreach($menu as $key => $val)
        <li class="submenu @if($parent_menu_id==$val['id']) active open @endif"><a href="/"><i class="{{$icon[$key]}}"></i> <span>{{$val['menu']}}</span></a>
        @if(is_array($val['sub_menu'])&&count($val['sub_menu']))
        <ul>
            @foreach($val['sub_menu'] as $k => $v)
            <li class="@if($v['id']==$sub_menu_id) active @endif"><a href="{{URL::to($v['menu_url'])}}">{{$v['menu']}}</a></li>
            @endforeach
        </ul>
        @endif
        </li>
        @endforeach
    </ul>
    <!--ul>
        <li class="active"><a href="/"><i class="icon icon-home"></i> <span>控制面板</span></a> </li>
        <li class="submenu"> <a href="javascript:void(0);"><i class="icon icon-signal"></i> <span>系统管理</span><span class="label label-important">3</span></a>
            <ul>
                <li><a href="{{URL::to('/user/index')}}">用户管理</a></li>
                <li><a href="{{URL::to('/user/grade')}}">级别管理</a></li>
                <li><a href="{{URL::to('/menu/index')}}">菜单维护</a></li>
            </ul>
        </li>
        <li> <a href="{{URL::to('/install/index')}}"><i class="icon icon-inbox"></i> <span>点位管理</span></a> </li>

        <li class="submenu"> <a href="#"><i class="icon icon-fullscreen"></i> <span>运维管理</span></a>
            <ul>
                <li><a href="/equipment/select">管理</a></li>
                <li><a href="{{URL::to('/equipment/maintain')}}">维修列表</a></li>
                <li><a href="{{URL::to('/material/index')}}">物料管理</a></li>
            </ul>
        </li>


        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>媒体管理</span> <span class="label label-important">2</span></a>
            <ul>
                <li><a href="{{URL::to('/media/index')}}">预售点位-列表</a></li>
                <li><a href="{{URL::to('/media/add')}}">预售点位-添加</a></li>

            </ul>
        </li>
        <li class="submenu"> <a href="#"><i class="icon icon-tint"></i> <span>销售管理</span> <span class="label label-important">2</span></a>
            <ul>
                <li><a href="{{URL::to('/custom/index')}}">客户信息列表</a></li>
                <li><a href="{{URL::to('/custom/edit')}}">添加客户信息</a></li>
            </ul>
        </li>

    </ul-->
</div>
<!--sidebar-menu-->
@show
<!--main-container-part-->
<div id="content">
    @yield('content')
</div>

<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
    <div id="footer" class="span12"> 2014 &copy; 玺越传媒 版权所有 </div>
</div>

<!--end-Footer-part-->
@section('js')
<script src="/admin/js/jquery.min.js"></script>
<script src="/admin/js/jquery.ui.custom.js"></script>
<script src="/admin/js/bootstrap.min.js"></script>
<script src="/admin/js/jquery.uniform.js"></script>
<script src="/admin/js/select2.min.js"></script>
<script src="/admin/js/jquery.dataTables.min.js"></script>
<script src="/admin/js/jquery.validate.js"></script>
<script src="/admin/js/matrix.js"></script>
<script src="/admin/js/matrix.tables.js"></script>
<script src="/admin/js/bootstrap-datepicker.js"></script>
<script lang="javascript">

function cityOut(obj,subElement){
     $.ajax({
         type: "POST",
         url: "/common/data-list",
         dataType: "json",
         data:{model:'City','father':obj.value},
         success: function(data){
             $('#'+subElement).empty(); //清空resText里面的所有内容
             $('#'+subElement).append("<option value=''>请选择</option>");
             $.each(data, function(i, item) {
                 $('#'+subElement).append("<option value='"+i+"'>"+item+"</option>");

             });
         }
     });
}

function regionalData(obj,subElement,model){
     $.ajax({
         type: "POST",
         url: "/common/data-list",
         dataType: "json",
         data:{model:model,father:obj.value},
         success: function(data){
             $('#'+subElement).empty(); //清空resText里面的所有内容
             $('#'+subElement).append("<option value='0'>请选择</option>");
             $.each(data, function(i, item) {
                 $('#'+subElement).append("<option value='"+i+"'>"+item+"</option>");
             });
         }
     });
}

function regionalData2(obj,subElement,model,val){
     $.ajax({
         type: "POST",
         url: "/common/data-list",
         dataType: "json",
         data:{model:model,father:obj.value},
         success: function(data){
             $('#'+subElement).empty(); //清空resText里面的所有内容
             $('#'+subElement).append("<option value='0'>请选择</option>");
             var tmp = $("#"+val).val();
             $.each(data, function(i, item) {
                 if(i==tmp)
                 {
                    $('#'+subElement).append("<option value='"+i+"' selected='selected'>"+item+"</option>");
                 }
                 else
                 {
                    $('#'+subElement).append("<option value='"+i+"'>"+item+"</option>");
                 }

             });
             $('select').select2();
         }
     });
}
obj = document.getElementById('province_id');
if(obj)
{
    regionalData2(obj,"city_id","City","tmp_city_id");
}

obj2 = document.getElementById('tmp_city_id');
if(obj2)
{
    regionalData2(obj2,"area_id","Area","tmp_area_id");
}

//$('input[type=checkbox],input[type=radio]').uniform();
$('select').select2();

</script>
@show
@yield('inline_scripts')
</body>
</html>
