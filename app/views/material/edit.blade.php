@extends('layout.layout')
@section('content')
<!-- PAGE CONTENT BEGINS -->
<div id="content-header">
    <div id="breadcrumb"><a href="{{URL::to('/')}}" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> 控制面板</a>
        <a href="{{URL::to('/custom/index')}}" class="tip-bottom">{{isset($config['parent_title'])?$config['parent_title']:""}}</a>
        <a href="#" class="current">{{$config['title']}}</a>
    </div>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>{{$config['title']}}</h5>
                    @if (Session::has('flag'))
                    <span class="error">操作失败，请重试！</span>
                    @endif
                </div>

                <div class="widget-content nopadding">
                    <form id="frm_edit" role="form" class="form-horizontal" action="{{$page['action_path']}}?{{Request::getQueryString()}}"
                          method="post">
                        @if($page['action_method']=='put')
                        <input type="hidden" name="_method" value="PUT"/>
                        @endif
                        @foreach($config['items'] as $key=>$item)
                        @if($item['type']=='image')
                        <div class="control-group">
                            <label for="ipt_{{$key}}" class="control-label">{{$item['title']}}</label>

                            <div id="container_{{$key}}" class="controls">
                                <a class="btn btn-default btn-lg " id="ipt_{{$key}}" href="#">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <sapn>选择文件</sapn>
                                </a>

                                <div id="preview_{{$key}}">
                                    @if(isset($data[$key])&&$data[$key])
                                    <img src="{{$data[$key]}}">
                                    @endif
                                </div>
                            </div>
                            <input class="need_uploader" value="{{$data[$key] or ''}}" id="hid_{{$key}}" type="hidden"
                                   name="{{$key}}"/>
                        </div>
                        <hr/>
                        @elseif($item['type']=='editor')
                        <div>
                            <h4 class="header green clearfix">
                                {{$item['title']}}
                            </h4>
                            <div class="wysiwyg-editor" id="by_editor_{{$key}}">{{$data[$key] or ''}}</div>
                            <textarea id="hid_{{$key}}" style="display: none" name="{{$key}}">
                                {{$data[$key] or ''}}
                            </textarea>
                        </div>
                        <hr/>
                        @elseif($item['type']=='hidden')
                        <input value="{{$data[$key] or ''}}" type="hidden" name="{{$key}}"/>
                        @elseif($item['type']=='password')
                        <div class="control-group">
                            <label for="ipt_{{$key}}" class="control-label">{{$item['title']}}</label>
                            <div class="controls">
                                <input autocomplete="false" name="{{$key}}"
                                       type="{{$item['type']}}"
                                       class="form-control"
                                       id="ipt_{{$key}}"
                                       placeholder="请输入{{$item['title']}}">
                            </div>

                        </div>

                        @elseif($item['type']=='plus_d'&&isset($data['plus_s']))
                        <div class="control-group">
                            <label for="ipt_{{$key}}" class="control-label">{{$item['title']}}</label>
                            @foreach(array_merge($data['plus_s'],isset($data[$key])?$data[$key]:[]) as $kk=> $vv)
                            <div class=".col-md-12">
                                {{$kk}} :
                                <input name="{{$key}}_v[]" type="text" value="{{$vv}}" placeholder="输入{{$kk}}"/>
                                <input name="{{$key}}_k[]" type="hidden" value="{{$kk}}"/>
                            </div>
                            @endforeach
                        </div>
                        @elseif($item['type']=='text')
                        <div class="control-group">
                            <label for="ipt_{{$key}}">{{$item['title']}}</label>
                            <textarea style="height: 300px" class="form-control" id="ipt_{{$key}}" name="{{$key}}">{{$data[$key] or ''}}</textarea>
                        </div>
                        @elseif($item['type']=='select')
                        <div class="control-group">
                            <label for="ipt_{{$key}}" class="control-label">{{$item['title']}}</label>
                            <div class="controls" style="width:267px;">
                            <select class="form-control" name="{{$key}}" id="{{$key}}" @if($key=='province_id')onclick="{{$item['func']}}"@endif>
                                <?php
                                    $list = $item['select-items'];
                                    if($key=='province_id')
                                    {
                                        $list = $list + $provinceList;
                                    }
                                    elseif($key=='city_id')
                                    {
                                        $list = $list+$cityList;
                                    }
                                    elseif($key=='material_cat_id')
                                    {
                                        $list = $list+$materialCatList;
                                    }
                                ?>
                                @foreach($list as $select_key=>$select_item)
                                    @if(isset($data[$key])&&$data[$key]==$select_key)
                                        <option selected value="{{$select_key}}">{{$select_item}}</option>
                                    @else
                                        <option value="{{$select_key}}">{{$select_item}}</option>
                                    @endif
                                @endforeach
                            </select>
                            </div>
                        </div>
                        @elseif($item['attribute']!=FORM_TYPE_ATTRIBUTE_LIST)
                        <div class="control-group">
                            <label for="ipt_{{$key}}" class="control-label">{{$item['title']}}</label>
                            <div class="controls">
                                <input autocomplete="false" value="{{$data[$key] or ''}}" name="{{$key}}"
                                   type="{{$item['type']}}"
                                   class="form-control"
                                   id="ipt_{{$key}}"
                                   placeholder="请输入{{$item['title']}}">
                            </div>
                        </div>
                        @endif
                        @endforeach

                        <div class="form-actions">
                            <button type="button" class="btn btn-prev" onclick="history.back(-1)">
                                <i class="icon-arrow-left"></i>
                                取消
                            </button>

                            <button type="submit" class="btn btn-success btn-next">
                                保存
                                <i class="icon-arrow-right icon-on-right"></i>
                            </button>
                        </div>
                    </form>

                    <!-- /widget-body -->
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('inline_scripts')
<script type="text/javascript">
	$(function () {
		$("#frm_edit").on('submit', function () {
			$('.wysiwyg-editor').each(function () {
				var html = $(this).html();
				$(this).next().html(html);
			});
		});
		$('a.plus_structure').on('click', function (e) {
			e.stopPropagation();
			e.preventDefault()
			var key = $(this).data('key');
			var html=$("#tpl_plus").html().replace(/\{key\}/g,key);
			$(this).after(html);
		});
	});

//	function cityOut(obj,subElement){
//         $.ajax({
//             type: "POST",
//             url: "/common/data-list",
//             dataType: "json",
//             data:{model:'City','father':obj.value},
//             success: function(data){
//                 $('#'+subElement).empty(); //清空resText里面的所有内容
//                 $('#'+subElement).append("<option value=''>请选择</option>");
//                 $.each(data, function(i, item) {
//                     $('#'+subElement).append("<option value='"+i+"'>"+item+"</option>");
//
//                 });
//             }
//         });
//     }
</script>
@stop

