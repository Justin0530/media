@extends('layout.layout')

@section('content')
<!--breadcrumbs-->
<div id="content-header">
    <div id="breadcrumb"> <a href="/" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 控制面板</a></div>
</div>
<!--End-breadcrumbs-->

<!--Action boxes-->
<div class="container-fluid">

<hr/>
<div class="row-fluid">
    <div class="row-fluid">
          <div class="span6">
            <div class="widget-box">
              <div class="widget-title bg_ly" data-toggle="collapse" href="#collapseG2"><span class="icon"><i class="icon-chevron-down"></i></span>
                <h5>系统消息</h5>
              </div>
              <div class="widget-content nopadding collapse in" id="collapseG2">
                <ul class="recent-posts">
                    @foreach($messageList as $key => $val)
                    <li>
                        <div class="user-thumb"> <img width="30" height="30" alt="User" src="/admin/img/email.png"> </div>
                        <div class="article-post">
                          <span class="user-info"> 类型:{{msg_status($val->m_type)}} / 时间: {{$val->created_at}} </span>
                          <p><a href="#">{{$val->message}}</a> </p>
                        </div>
                      </li>
                    @endforeach
                </ul>
              </div>
            </div>
            <div class="widget-box">
              <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
                <h5>任务列表</h5>
              </div>
              <div class="widget-content">
                <div class="todo">
                  <ul>
                    <!--li class="clearfix">
                      <div class="txt"> Luanch This theme on Themeforest <span class="by label">Nirav</span> <span class="date badge badge-important">Today</span> </div>
                      <div class="pull-right"> <a class="tip" href="#" title="Edit Task"><i class="icon-pencil"></i></a> <a class="tip" href="#" title="Delete"><i class="icon-remove"></i></a> </div>
                    </li-->
                    @foreach($taskList as $key => $val)
                    <li class="clearfix">
                      <div class="txt">
                          {{$val->message}}
                          <span class="by label">{{$val->recevier}}</span>
                          <span class="date badge badge-warning">Today</span>
                      </div>
                      <div class="pull-right">
                          <a class="tip" href="#" title="Edit Task"><i class="icon-pencil"></i></a>
                          <a class="tip" href="#" title="Delete"><i class="icon-remove"></i></a>
                      </div>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="span6">
            <div class="widget-box">
              <div class="widget-title"> <span class="icon"><i class="icon-ok"></i></span>
                <h5>系统说明</h5>
              </div>
              <div class="widget-content">
                <div class="widget-content">
                <!--Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                    , quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                 Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu f
                 ugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa
                 qui officia deserunt mollit anim id est laborum.-->
                 </div>
              </div>
            </div>
            <div class="widget-box">
              <div class="widget-title bg_lo"  data-toggle="collapse" href="#collapseG3" > <span class="icon"> <i class="icon-chevron-down"></i> </span>
                <h5>最近更新</h5>
              </div>
              <div class="widget-content nopadding updates collapse in" id="collapseG3">
                <!--
                <div class="new-update clearfix"><i class="icon-ok-sign"></i>
                  <div class="update-done"><a title="" href="#"><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</strong></a> <span>dolor sit amet, consectetur adipiscing eli</span> </div>
                  <div class="update-date"><span class="update-day">20</span>jan</div>
                </div>
                -->
              </div>
            </div>
          </div>
        </div>
</div>
@stop

