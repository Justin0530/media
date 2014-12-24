<?php

class MaterialController extends BaseController {

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

	protected $Model = 'Material';

    public function index()
    {
        $class = $this->Model;
        $sql = '1=1';
        $sqlArr = array();
        $name = Input::get('name','');
        $province_id = Input::get('province_id','');
        $city_id = Input::get('city_id','');
        if($name)
        {
            $sql .= " and name like ?";
            $sqlArr[] = '%'.$name.'%';
        }

        if($province_id)
        {
            $sql .= " and province_id='?'";
            $sqlArr[] = $province_id;
        }

        if($city_id)
        {
            $sql .= " and city_id='?'";
            $sqlArr[] = $city_id;
        }

        $data = $class::whereRaw($sql,$sqlArr)->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $admin_config = get_class_vars($class)['admin_config'] ? : [];
        $template = isset($admin_config['template_index']) ? $admin_config['template_index'] : 'crud.index';
        $provinceList = Province::select(['id','province'])->get()->lists('province','id');
        $cityList = City::select(['id','city_name'])->get()->lists('city_name','id');
        return View::make($template, [
            'page'         => [],
            'title'        => '运维管理',
            'data'         => $data,
            'config'       => $admin_config,
            'provinceList' => $provinceList,
            'cityList'     => $cityList,
            'keyword'      => $name,
            'province_id'  => $province_id,
            'city_id'      => $city_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /tests/create
     *
     * @return Response
     */
    public function create()
    {
        $admin_config = get_class_vars($this->Model)['admin_config'] ? : [];
        $template     = isset($admin_config['template_edit']) ? $admin_config['template_edit'] : 'crud.edit';
        $provinceList = Province::select(['id','province'])->get()->lists('province','id');
        $cityList = City::select(['id','city_name'])->get()->lists('city_name','id');
        $materialCatList = MaterialCat::select(['id','material_cat'])->get()->lists('material_cat','id');

        return View::make($template, [
            'page'   => [
                'action_path'   => $admin_config['router'],
                'action_method' => 'post',
                'scripts'       => [],
            ],
            'data'            => Request::all(),
            'config'          => $admin_config,
            'provinceList'    => $provinceList,
            'cityList'        => $cityList,
            'materialCatList' => $materialCatList,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     * POST /tests
     *
     * @return Response
     */
    public function store()
    {
        $admin_config = get_class_vars($this->Model)['admin_config'] ? : [];
        $rules        = $this->getRules($admin_config);
        $data         = Input::all();
        if (count($rules)) {
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                $messages = [];
                foreach ($validator->messages()->all() as $message) {
                    $messages[] = [
                        'class' => 'danger',
                        'text'  => $message,
                    ];
                }
                Session::flash('messages', $messages);
            }
        }
        $class = $this->Model;
        $obj   = new $class;
        $this->saveObject($obj, $data, $admin_config);

        return Redirect::intended($admin_config['router'] . '?' . Request::getQueryString());
    }

    /**
     * Display the specified resource.
     * GET /tests/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->edit($id);

    }

    /**
     * Show the form for editing the specified resource.
     * GET /tests/{id}/edit
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $pathinfo     = str_replace('/edit', '', Request::getPathInfo());
        $admin_config = get_class_vars($this->Model)['admin_config'] ? : [];
        $action_path  = isset($admin_config['store_path']) ? $admin_config['store_path'] : $pathinfo;
        $class        = $this->Model;
        $data         = $class::find($id);
        $provinceList = Province::select(['id','province'])->get()->lists('province','id');
        $cityList = City::select(['id','city_name'])->get()->lists('city_name','id');
        $materialCatList = MaterialCat::select(['id','material_cat'])->get()->lists('material_cat','id');

        $data = array_merge(Request::all(), $data->toArray());

        $template = isset($admin_config['template_edit']) ? $admin_config['template_edit'] : 'crud.edit';

        return View::make($template, [
            'page'   => [
                'action_path'   => $action_path,
                'action_method' => 'put',
                'scripts'       => [],
            ],
            'config' => $admin_config,
            'data'   => $data,
            'provinceList' => $provinceList,
            'cityList'     => $cityList,
            'materialCatList'=> $materialCatList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /tests/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

        $admin_config = get_class_vars($this->Model)['admin_config'] ? : [];
        $rules        = $this->getRules($admin_config);
        $data         = Input::all();

        if (count($rules)) {
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                $messages = [];
                foreach ($validator->messages()->all() as $message) {
                    $messages[] = [
                        'class' => 'danger',
                        'text'  => $message,
                    ];
                }
                Session::flash('messages', $messages);

                return Redirect::to($admin_config['router'] . '/' . $id . '/edit');
            }

        }
        $class = $this->Model;

        $obj = $class::find($id);
        $data['total_num'] = $data['num'] + $data['error_num'];
        $this->saveObject($obj, $data, $admin_config);

        return Redirect::intended($admin_config['router'] . '?' . Request::getQueryString());
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /tests/{id}
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $admin_config = get_class_vars($this->Model)['admin_config'] ? : [];
        $class        = $this->Model;
        $obj          = $class::find($id);
        $obj->delete();

        // redirect
        Session::flash('messages', [
            [
                'class' => 'info',
                'text'  => 'Successfully deleted!',
            ]
        ]);

        return Redirect::to($admin_config['router'] . '?' . Request::getQueryString());
    }

    protected function getRules($config)
    {
        $rules = [];
        foreach ($config['items'] as $key => $item) {
            if (isset($item['validator'])) {
                $rules[$key] = $item['validator'];
            }
        }

        return $rules;

    }

    protected function saveObject($obj, $data, $admin_config)
    {
        foreach ($admin_config['items'] as $key => $value) {
            if ($value['type'] === 'password') {
                if ($obj[$key] != '') {
                    $obj[$key] = Hash::make($data[$key]);
                } else {
                    unset($obj[$key]);
                }

            } elseif ($value['type'] === 'plus_s') {
                $plus_structure_k = Input::get($key . '_k');
                $plus_structure_v = Input::get($key . '_v');
                $plus_structure   = [];
                if (count($plus_structure_v) === count($plus_structure_k)) {
                    if ($plus_structure_k) {
                        foreach ($plus_structure_k as $k => $v) {
                            $plus_structure[$v] = $plus_structure_v[$k];
                        }
                    }
                }
                $obj[$key] = ($plus_structure);
            } elseif ($value['type'] === 'plus_d') {
                $plus_structure_k = Input::get($key . '_k');
                $plus_structure_v = Input::get($key . '_v');
                $plus_structure   = [];
                if (count($plus_structure_v) === count($plus_structure_k)) {
                    if ($plus_structure_k) {
                        foreach ($plus_structure_k as $k => $v) {
                            $plus_structure[$v] = $plus_structure_v[$k];
                        }
                    }
                }
                $obj[$key] = ($plus_structure);
            } elseif(isset($value['attribute'])&&$value['attribute']!= FORM_TYPE_ATTRIBUTE_LIST) {
                $obj[$key] = $data[$key];
            }
        }

        $obj->save();

        return $obj;
    }
}
