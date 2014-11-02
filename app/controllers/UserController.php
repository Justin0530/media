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
            return Redirect::intended();
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
        Session::flush();
        return Redirect::to('login');
    }

    public function index()
    {
        $userList = User::with('grade')->orderBy('id', 'desc')->paginate($this->pageSize);
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
            $province_id = Input::get('province_id','');
            $city_id     = Input::get('city_id','');
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
                    'province_id' => $province_id,
                    'city_id'     => $city_id,
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
        $data['provinceList'] = Province::select(['id','province'])->get()->lists('province','id');
        $data['cityList'] = City::select(['id','city_name'])->get()->lists('city_name','id');
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
        $data = array('title' => '添加用户级别');
        $tree = array();
        $grade = 3;
        $menu = new Menu();
        $menu_list = $menu->getMenuTree($grade,$tree);
        $data['menu_list'] = $menu_list;
        if(Request::getMethod()=='POST')
        {
            $grade = new Grade();
            $arr['grade_name']  = Input::get('grade_name');
            $arr['desc']        = Input::get('desc');
            $arr['range']       = Input::get('range');
            $arr['status']      = Input::get('status');
            $arr['author_id']   = Auth::user()->id;
            $authority          = Input::get('authority');
            if(!$grade->validate($arr,$grade->getRules()))
            {
                $errors = $grade->errors();
                return Redirect::to('user/addGrade')->with('user',Auth::user())->withErrors($errors)->withInput();
            }

            $rs = $grade->fill($arr)->save();
            if($rs&&$arr['range']=='2')
            {
                foreach($authority as $key => $val)
                {
                    $gradeMenu = new GradeMenu();
                    $gradeMenu->grade_id = $grade->id;
                    $gradeMenu->menu_id  = $val;
                    $gradeMenu->save();
                }
            }

            return Redirect::to('grade/index');
        }
        return View::make('user.add-grade',$data);
    }

    public function editGrade($grade_id)
    {
        $data = array('title' => '编辑用户级别');
        $tree = array();
        $grade = 3;
        $menu = new Menu();
        $menu_list = $menu->getMenuTree($grade,$tree);
        $data['menu_list'] = $menu_list;
        $grade = new Grade();
        $grade_info = $grade->find($grade_id);
        //$grade_menu = $grade_info->gradeMenu();
        $menu_id_arr = array();
        foreach($grade_info->gradeMenu as $key => $val)
        {
            array_push($menu_id_arr,$val->menu_id);
        }
        $data['grade_info'] = $grade_info;
        $data['menu_id_arr'] = $menu_id_arr;
        if(Request::getMethod()=='POST')
        {
            $arr['grade_name']  = Input::get('grade_name');
            $arr['desc']        = Input::get('desc');
            $arr['range']       = Input::get('range');
            $arr['status']      = Input::get('status');
            $authority          = Input::get('authority');
            if(!$grade->validate($arr,$grade->getRules()))
            {
                $errors = $grade->errors();
                return Redirect::to('user/addGrade')->with('user',Auth::user())->withErrors($errors)->withInput();
            }

            $grade_info->grade_name = $arr['grade_name'];
            $grade_info->desc       = $arr['desc'];
            $grade_info->status     = $arr['status'];
            $grade_info->range      = $arr['range'];
            $grade_info->author_id  = Auth::user()->id;
            $rs = $grade_info->save();
            if($rs&&$arr['range']=='2')
            {
                GradeMenu::where('grade_id','=',$grade_info->id)->delete();
                if(count($authority))
                {
                    foreach($authority as $key => $val)
                    {
                        $gradeMenu = new GradeMenu();
                        $gradeMenu->grade_id = $grade_info->id;
                        $gradeMenu->menu_id  = $val;
                        $gradeMenu->save();
                    }
                }

            }

            return Redirect::to('user/grade');
        }
        return View::make('user.edit-grade',$data);
    }

    public function lookGrade($grade_id)
    {
        $data = array('title' => '查看用户级别');
        $tree = array();
        $grade_level = 3;
        $menu = new Menu();
        $menu_list = $menu->getMenuTree($grade_level,$tree);
        $data['menu_list'] = $menu_list;
        $grade = new Grade();
        $grade_info = $grade->find($grade_id);
        $menu_id_arr = array();
        foreach($grade_info->gradeMenu as $key => $val)
        {
            array_push($menu_id_arr,$val->menu_id);
        }
        $data['grade_info'] = $grade_info;
        $data['menu_id_arr'] = $menu_id_arr;
        return View::make('user.look-grade',$data);
    }

    public function delGrade($ids)
    {
        $idArr = explode(',',$ids);
        $grade = new Grade();
        $gradeMenu = new GradeMenu();
        foreach($idArr as $key => $val)
        {
            $grade->where('id','=',$val)->delete();
            $gradeMenu->where('grade_id','=',$val)->delete();
        }
        echo 'success';
        exit();
    }
}
