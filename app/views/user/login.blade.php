<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>用户登录——玺越传媒</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="/admin/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/admin/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="/admin/css/matrix-login.css" />
        <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href='/admin/css/font-face.css' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">
            {{ Form::open(array('url' => URL::to('doLogin'),'id'=>'loginform','class'=>'form-vertical')) }}

				 <div class="control-group normal_text"> <h3><img src="/admin/img/logo.png" alt="Logo" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"></i></span>{{Form::text('email','',array('placeholder'=>'邮箱'));}}
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span>{{Form::password('password',array('placeholder'=>'密码'));}}
                        </div>
                        @if($loginStatus=='error')
                        <span style="margin-left: 30px;">您输入的邮箱或密码有误</span>
                        @endif

                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">忘记密码?</a></span>
                    <span class="pull-right">{{Form::submit('登录',array('id'=>'sub','class'=>'btn btn-success'))}}</span>
                </div>
            {{Form::close()}}
            <form id="recoverform" action="#" class="form-vertical">
				<p class="normal_text">请输入您的邮箱，我们将把您的密码发送到你的邮箱.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; 返回登录</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>提交</a></span>
                </div>
            </form>
        </div>
        
        <script src="/admin/js/jquery.min.js"></script>
        <script src="/admin/js/matrix.login.js"></script>
    </body>

</html>
