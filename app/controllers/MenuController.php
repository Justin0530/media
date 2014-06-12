<?php

class MenuController extends BaseController {

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
            $arr['f_parent_id']  = Input::get('f_parent_id');
            $arr['parent_id']    = Input::get('parent_id');
            $arr['status']       = Input::get('status');


            //var_dump(Session::all());
            //var_dump(Auth::user()->id);exit();
            $menu = new Menu();
            if(!$menu->validate($arr,$menu->getRules()))
            {
                $error = $menu->errors();
                return Redirect::to('menu/add')->with('user',Auth::user())->withErrors($error)->withInput();
            }
            $arr['author_id'] = Auth::user()->id();
            $menu = new Menu();
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
        $data['title']     = '添加菜单';
        $data['fParentList'] = $fParentList;
        $data['parentList'] = $parentList;
        return View::make('menu.add',$data);
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        $fParentList = $menu->where('status','=','1')->where('menu_grade','=','1')->lists('menu','id');
        $parentList  = $menu->where('status','=','1')->where('menu_grade','=','2')->get();
        $data['title']     = '编辑菜单';
        $data['fParentList'] = $fParentList;
        $data['parentList'] = $parentList;
        if(Request::getMethod()=='POST')
        {
            $menu->menu         = $arr['menu'] = Input::get('menu');
            $menu->menu_url     = Input::get('menu_url');
            $f_parent_id        = $data['fParentList'] = Input::get('f_parent_id');
            $menu->parent_id    = Input::get('parent_id');
            $menu->status       = $arr['status'] = Input::get('status');
            if($menu->validate($arr,$menu->getRules()))
            {
                $error = $menu->errors();
                return Redirect::to('menu/edit/'.$menu->id)->with('error',$error);
            }
            $arr['author_id'] = Auth::user()->id();
            $result = $menu->save();
            if($result)
            {
                return Redirect::to('menu/index');
            }else{
                return Redirect::to('menu/edit/'.$menu->id)->with('flag',true);
            }

        }

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
