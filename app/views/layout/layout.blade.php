<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$title}}————玺越传媒</title>
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
        <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">消息</span> <span class="label label-important">5</span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i>写消息</a></li>
                <li class="divider"></li>
                <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i>收件箱</a></li>
                <li class="divider"></li>
                <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i>发件箱</a></li>
                <li class="divider"></li>
                <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i>垃圾箱</a></li>
            </ul>
        </li>
        <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">设置</span></a></li>
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
<div id="sidebar"><a href="{{URL::to('/')}}" class="visible-phone"><i class="icon icon-home"></i> 控制面板</a>
    <ul>
        <li class="active"><a href="/"><i class="icon icon-home"></i> <span>控制面板</span></a> </li>
        <li class="submenu"> <a href="javascript:void(0);"><i class="icon icon-signal"></i> <span>系统管理</a>
            <ul>
                <li><a href="{{URL::to('/user/index')}}">用户管理</a></li>
                <li><a href="{{URL::to('/user/grade')}}">级别管理</a></li>
                <li><a href="{{URL::to('/menu/index')}}">菜单维护</a></li>
            </ul>
        </li>
        <li> <a href="{{URL::to('/install/index')}}"><i class="icon icon-inbox"></i> <span>点位管理</span></a> </li>
        <li><a href="tables.html"><i class="icon icon-th"></i> <span>Tables</span></a></li>
        <li><a href="grid.html"><i class="icon icon-fullscreen"></i> <span>Full width</span></a></li>
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Forms</span> <span class="label label-important">3</span></a>
            <ul>
                <li><a href="form-common.html">Basic Form</a></li>
                <li><a href="form-validation.html">Form with Validation</a></li>
                <li><a href="form-wizard.html">Form with Wizard</a></li>
            </ul>
        </li>
        <li><a href="buttons.html"><i class="icon icon-tint"></i> <span>Buttons &amp; icons</span></a></li>
        <li><a href="interface.html"><i class="icon icon-pencil"></i> <span>Eelements</span></a></li>
        <li class="submenu"> <a href="#"><i class="icon icon-file"></i> <span>Addons</span> <span class="label label-important">5</span></a>
            <ul>
                <li><a href="index2.html">Dashboard2</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="calendar.html">Calendar</a></li>
                <li><a href="invoice.html">Invoice</a></li>
                <li><a href="chat.html">Chat option</a></li>
            </ul>
        </li>
        <li class="submenu"> <a href="#"><i class="icon icon-info-sign"></i> <span>Error</span> <span class="label label-important">4</span></a>
            <ul>
                <li><a href="error403.html">Error 403</a></li>
                <li><a href="error404.html">Error 404</a></li>
                <li><a href="error405.html">Error 405</a></li>
                <li><a href="error500.html">Error 500</a></li>
            </ul>
        </li>
        <li class="content"> <span>Monthly Bandwidth Transfer</span>
            <div class="progress progress-mini progress-danger active progress-striped">
                <div style="width: 77%;" class="bar"></div>
            </div>
            <span class="percent">77%</span>
            <div class="stat">21419.94 / 14000 MB</div>
        </li>
        <li class="content"> <span>Disk Space Usage</span>
            <div class="progress progress-mini active progress-striped">
                <div style="width: 87%;" class="bar"></div>
            </div>
            <span class="percent">87%</span>
            <div class="stat">604.44 / 4000 MB</div>
        </li>
    </ul>
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
@show
</body>
</html>
