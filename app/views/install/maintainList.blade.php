@extends('layout.layout')

@section('content')

<div id="content-header">
    <div id="breadcrumb"><a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a>
        <a href="/install/index" class="tip-bottom">点位管理</a> <a href="/install/maintainList" class="current">渠道维护</a></div>
    <!--    <h1>级别列表</h1>-->
</div>
<br />
<div class="container-fluid">
    {{Form::open(array('url' => '/install/maintainList','method'=>'post'))}}
    <div>
        <span class="span" style="margin-left: 10px;margin-right: 15px;">{{Form::text('kid',$kid,array('id'=>'kid','placeholder'=>'点位号'))}}</span>
        <span class="span2" style="margin-left: 10px;"><input type="submit" value="查询" class="btn btn-success"></span>
    </div>
    {{Form::close()}}
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-content nopadding">
                    <table class="table table-bordered table-striped with-check">
                        <thead>
                        <tr>
                            <th style="width:30px;">序号</th>
                            <th>点位编号</th>
                            <th>是否接受赠品</th>
                            <th>沟通是否有难度</th>
                            <th>是否可以做活动</th>
                            <th>营销推广</th>
                            <th>培训广告</th>
                            <th>审核</th>
                            <th>幼儿园需要画面数量</th>
                            <th>广告数量</th>
                            <th>备注</th>
                            <th>维护人</th>
                            <th>维护时间</th>
                            <th>下次维护时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($maintainList as $key => $val)
                        <tr>
                            <td>{{$val->id}}</td>
                            <td>{{$val->kid}}</td>
                            <td>{{$val->gift=='1'?'是':'否'}}</td>
                            <td>{{$val->communication=='1'?'是':'否'}}</td>
                            <td>{{$val->activies=='1'?'是':'否';}}</td>
                            <td>{{$val->promotion=="1"?'是':'否'}}</td>
                            <td>{{$val->english_ad=='1'?'是':'否'}}</td>
                            <td>{{$val->examine=='1'?'需要':'不需要'}}</td>
                            <td>{{$val->k_frame}}</td>
                            <td>{{$val->ad_frame}}</td>
                            <td title="{{$val->remark}}">{{substr($val->remark,0,30)}}</td>
                            <td>{{$val->maintain_person}}</td>
                            <td>{{$val->maintain_time}}</td>
                            <td>{{$val->next_maintain_time}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{$maintainList->links();}}
            <!--p style="float: right;">
                <button id="maintain" class="btn btn-success"><i class="icon-bookmark-empty"></i></i>  渠道维护</button>
                <button id="edit" class="btn btn-success"><i class="icon-edit"></i></i>  编辑</button>
                <button id="look" class="btn btn-success"><i class="icon-eye-open"></i></i>  查看</button>
            </p-->

        </div>
    </div>
</div>
@stop

@section('js')
@parent
<script>
    $(function () {
        $(":button[id='maintain']").click(function () {
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
                alert("请选择一个点位");
                return false;
            } else {
                location.href = "{{URL::to('/install/maintain')}}?kid=" + checks;
            }
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
                alert("请选择一个点位");
                return false;
            } else {
                location.href = "{{URL::to('/install/add')}}?id=" + checks;
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
                alert("请选择一个客户");
                return false;
            } else {
                location.href = "{{URL::to('/install/add')}}?act=show&id=" + checks;
            }
        });
        $(":button[id='look']").click(function (){
            location.href = "{{URL::to('/install/add')}}/?id="+checks;
        })
        $(":button[id='del']").click(function () {
            var checks = "";
            $(":checkbox[name='lineNum']").each(function () {
                if ($(this).prop("checked")) {
                    checks += $(this).val() + ",";
                }
            });
            checks = checks.substr(0, checks.length - 1);

            if ($.trim(checks) == '') {
                alert("请选择一个用户");
                return false;
            } else {
                if (confirm('真的删除该菜单吗?')) {
                    $.post("{{URL::to('menu/del')}}/" + checks,
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
