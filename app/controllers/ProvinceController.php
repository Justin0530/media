<?php

class ProvinceController extends CrudController {

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
    protected $Model = 'Province';

    public function index()
    {
        $class = $this->Model;
        $keyword = Input::get('name');
        $sql = '1=1';
        $sqlArr = array();
        $whereArr = [];
        if($keyword)
        {
            $sql .= " and province like ?";
            $sqlArr[] = "%$keyword%";
            $whereArr['name'] = $keyword;
        }
        $data = $class::whereRaw($sql,$sqlArr)->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $admin_config = get_class_vars($class)['admin_config'] ? : [];
        $template = isset($admin_config['template_index']) ? $admin_config['template_index'] : 'region.index';
        return View::make($template, [
            'page'   => [],
            'data'   => $data,
            'config' => $admin_config,
            'whereArr'=> $whereArr,
        ]);
    }
}
