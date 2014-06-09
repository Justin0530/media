<?php

class UserController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function login()
	{
        //var_dump(Request::getMethod());exit();
        //var_dump(Input::get('username'));
        //var_dump(Input::get('password'));
        $password = Hash::make('secret');
        if (Auth::check())
        {
            return Redirect::to('/');
        }else{
            return View::make('user.login',array('loginStatus'=>''));
        }

	}

    public function doLogin()
    {
        $rs = User::doLogin();
        if(!$rs)
        {
            return View::make('user.login',array('loginStatus'=>'error'));
        }else{
            return Redirect::to('/');
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('login');
    }

    public function index()
    {
        $userList = User::with('grade')->orderBy('created_at', 'desc')->paginate(1);
        return View::make('user.index',array('title' => '用户列表','userList'=>$userList));
    }

    public function add()
    {

        if(Request::getMethod()=='POST')
        {
            $truename    = Input::get('truename');
            $grade       = Input::get('grade');
            $email       = Input::get('email');
            $mobile      = Input::get('mobile');
            $password    = Input::get('password');
            $resignation = Input::get('resignation');
            if(empty($email)||empty($grade)||empty($password))
            {
                return Redirect::to('user/add')->with('flag',true);
            }
            else
            {
                $arr = array(
                    'truename'    => $truename,
                    'email'       => $email,
                    'password'    => $password,
                    'mobile'      => $mobile,
                    'grade_id'    => $grade,
                    'resignation' => $resignation,
                );
            }
            $rules = array(
                'truename' => 'required',
                'email'    => 'unique:users,email|required',
                'password' => 'required|min:6|max:20',
                'mobile'   => 'required',
                'grade_id' => 'required',
            );

            $v = Validator::make($arr,$rules);
            if($v->fails())
            {
                return Redirect::to('user/add')->with('user',Auth::user())->withErrors($v)->withInput();
            }
            $arr['password'] = Hash::make($arr['password']);
            $user = new User();
            $user->fill($arr);
            $result = $user->save();
            if($result)
            {
                return Redirect::to('user/index');
            }else{
                return Redirect::to('user/add')->with('flag',true);
            }

        }
        $grade     = new Grade();
        $gradeList = $grade->where('status','=','1')->lists('grade_name','id');
        $data['title']     = '添加用户';
        $data['gradeList'] = $gradeList;
        return View::make('user.add',$data);
    }

    public function edit($id)
    {
        $user = User::find($id);
        if(Request::getMethod()=='POST')
        {
            $truename    = Input::get('truename');
            $grade       = Input::get('grade');
            $email       = Input::get('email');
            $mobile      = Input::get('mobile');
            $password    = Input::get('password');
            $resignation = Input::get('resignation');
            if(empty($email)||empty($grade))
            {
                return Redirect::to('user/edit/'.$user->id)->with('flag',true);
            }
            else
            {
                $arr = array(
                    'truename'    => $truename,
                    'email'       => $email,
                    'password'    => $password,
                    'mobile'      => $mobile,
                    'grade_id'    => $grade,
                    'resignation' => $resignation,
                );
            }
            $rules = array(
                'email'    => 'unique:users,email|required',
            );

            $v = Validator::make($arr,$rules);
            if($v->fails()&&$arr['email']!=$user->email)
            {
                return Redirect::to('user/edit/'.$user->id)->with('user',Auth::user())->withErrors($v)->withInput();
            }else{
                $user->email = $email;
            }
            if(!empty($arr['password'])){
                $user->password = Hash::make($arr['password']);
            }

            if(!empty($mobile))
            {
                $user->mobile = $mobile;
            }

            if(!empty($grade))
            {
                $user->grade_id = $grade;
            }

            if(!empty($resignation)||$resignation==='0')
            {
                $user->resignation = $resignation;
            }
            $result = $user->save();
            if($result)
            {
                return Redirect::to('user/index');
            }else{
                return Redirect::to('user/edit/'.$user->id)->with('flag',true);
            }

        }
        $grade             = new Grade();
        $gradeList         = $grade->where('status','=','1')->lists('grade_name','id');
        $data['title']     = '编辑用户';
        $data['gradeList'] = $gradeList;
        $data['user']      = $user;
        return View::make('user.edit',$data);
    }

    public function del($ids)
    {
        $idArr = explode(',',$ids);
        $user = new User();
        foreach($idArr as $key => $val)
        {
            $user->where('id','=',$val)->delete();
        }
        echo 'success';
        exit();
    }
    public function grade()
    {
        $gradeList = Grade::all();
        $grade = array
        (
            'title' => '用户级别列表',
            'gradeList'  => $gradeList,
        );


        return View::make('user.gIndex',$grade);
    }

    public function addGrade()
    {
        $grade = array('title' => '用户级别');
        if(Request::getMethod()=='POST')
        {

        }
        return View::make('user.add-grade',$grade);
    }

}
