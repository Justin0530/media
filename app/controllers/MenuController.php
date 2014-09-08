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
        $menuList = Menu::with('author')->orderBy('menu_grade', 'asc')->paginate($this->pageSize);
        return View::make('menu.index',array('title' => '菜单维护','menuList'=>$menuList));
    }

    public function add()
    {

        if(Request::getMethod()=='POST')
        {
            $arr['menu']         = Input::get('menu');
            $arr['menu_url']     = Input::get('menu_url');
            $arr['parent_id']    = Input::get('parent_id');
            $arr['status']       = Input::get('status');
            list($arr['menu_grade'],$arr['parent_id']) = explode('-',$arr['parent_id']);
            $arr['menu_grade'] = $arr['menu_grade'] + 1;

            $menu = new Menu();
            $menu_grade = '1';
            if(!$menu->validate($arr,$menu->getRules()))
            {
                $error = $menu->errors();
                return Redirect::to('menu/add')->with('user',Auth::user())->withErrors($error)->withInput();
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
        $grade = 2;
        $tree = $menu->getMenuTree($grade,array());
        $data['title']     = '添加菜单';
        $data['tree'] = $tree;
        return View::make('menu.add',$data);
    }

    public function edit($id)
    {
        $object = new Menu();
        $menu = Menu::find($id);
        $grade = 2;
        $tree = $object->getMenuTree($grade,array());
        $data['tree'] = $tree;
        if(Request::getMethod()=='POST')
        {
            $menu->menu         = $arr['menu'] = Input::get('menu');
            $menu->menu_url     = Input::get('menu_url');
            $menu->parent_id    = $arr['parent_id'] = Input::get('parent_id');
            $menu->status       = $arr['status']= Input::get('status');

            if(!$menu->validate($arr,$menu->getRules()))
            {
                $error = $menu->errors();
                return Redirect::to('menu/edit')->with('user',Auth::user())->withErrors($error)->withInput();
            }
            list($menu->menu_grade,$menu->parent_id) = explode('-',$arr['parent_id']);
            $menu->menu_grade = $menu->menu_grade + 1;
            $menu->author_id = Auth::user()->id;
            $result = $menu->save();
            if($result)
            {
                return Redirect::to('menu/index');
            }else{
                return Redirect::to('menu/add')->with('flag',true);
            }

        }
        $data['menu']   =  $menu;
        $data['title']  = '编辑菜单';

        return View::make('menu.edit',$data);
    }

    public function del($ids)
    {
        $idArr = explode(',',$ids);
        $menu = new Menu();
        foreach($idArr as $key => $val)
        {
            $menu->where('id','=',$val)->delete();
        }
        echo 'success';
        exit();
    }
}
