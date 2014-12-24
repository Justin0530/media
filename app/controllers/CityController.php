<?php

class CityController extends CrudController {

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
    protected $Model = 'City';

    public function index()
    {
        $class = $this->Model;
        $keyword = Input::get('name');
        $province_id = Input::get('father_id');
        $sql = '1=1';
        $sqlArr = array();
        $whereArr = array();
        if($province_id)
        {
            $sql     .= " and father = ? ";
            $sqlArr[] = $province_id;
            $whereArr['father_id'] = $province_id;
        }
        if($keyword)
        {
            $sql .= " and city_name like ?";
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
            'whereArr' => $whereArr,
        ]);
    }
}
