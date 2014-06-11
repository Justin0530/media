<?php

class InstallController extends BaseController {

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

	public function index()
    {
        $menuList = Menu::with('author')->orderBy('created_at', 'desc')->paginate($this->pageSize);
        return View::make('menu.index',array('title' => '菜单维护','menuList'=>$menuList));
    }

    public function add()
    {

        if(Request::getMethod()=='POST')
        {
            $arr['menu']         = Input::get('menu');
            $arr['menu_url']     = Input::get('menu_url');
            $fParentId           = Input::get('f_parent_id');
            $arr['parent_id']    = Input::get('parent_id');
            $arr['status']       = Input::get('status');

            $menu = new Menu();
            $menu_grade = '1';
            if(!$menu->validate($arr,$menu->getRules()))
            {
                $error = $menu->errors();
                return Redirect::to('menu/add')->with('user',Auth::user())->withErrors($error)->withInput();
            }
            if($fParentId && $arr['parent_id'])
            {
                $menu_grade = '3';
            }
            elseif($fParentId && !$arr['parent_id'])
            {
                $menu_grade = '2';
            }
            $arr['menu_grade'] = $menu_grade;
            $arr['author_id'] = Auth::user()->id;
            $menu->fill($arr);
            $result = $menu->save();
            if($result)
            {
                return Redirect::to('menu/index');
            }else{
                return Redirect::to('menu/add')->with('flag',true);
            }

        }
        $menu     = new Menu();
        $fParentList = $menu->where('status','=','1')->where('menu_grade','=','1')->lists('menu','id');
        $parentList = $menu->where('status','=','1')->where('menu_grade','=','2')->get();
        $data['title']     = '添加用户';

        $data['fParentList'] = $fParentList;
        $data['parentList'] = $parentList;
        return View::make('menu.add',$data);
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
