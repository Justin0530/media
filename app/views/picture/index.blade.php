@extends('layout.layout')

@section('content')
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="#" class="tip-bottom">设计管理</a> <a href="#" class="current">图库管理</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<!--End-breadcrumbs-->
<br>
<div class="container">
    <div class="container-fluid"><hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-picture"></i> </span>
                            <h5>图片展示</h5>
                        </div>
                        <div class="widget-content">
                            <ul class="thumbnails">
                                @foreach($pictureList as $key => $val)
                                <li class="span2"> <a> <img class="lightbox" src="{{$val->image_path}}" alt="" > </a>
                                    <div class="actions">
                                        <a title="下载" href="#"><i class="icon-pencil"></i></a>
                                        <a class="lightbox_trigger" href="{{$val->image_path}}"><i class="icon-search"></i></a>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    {{$pictureList->links()}}
                </div>
            </div>
        </div>
</div>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
@stop

@section('js')
@parent
<script>
    $(function () {
        $(":button[id='add']").click(function () {
            location.href = "/menu/add";
        });

    });
</script>

@stop
