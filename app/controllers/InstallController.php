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
        //$menuList = Menu::with('author')->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $sql = '1=1';
        $sqlArr = array();
        $name = Input::get('name','');
        $type = Input::get('type','');
        $province_id = Input::get('province_id','');
        $city_id = Input::get('city_id','');
        $area_id = Input::get('area_id','');
        $grade_id = Input::get('grade_id');
        if($name)
        {
            $sql .= " and name like '%$name%'";
        }
        if($type)
        {
            $sql .= " and type = '$type'";
        }
        if($province_id)
        {
            $sql .= " and province_id = '$province_id'";
        }
        if($city_id)
        {
            $sql .= " and city_id = '$city_id'";
        }
        if($city_id)
        {
            $sql .= " and area_id = '$area_id'";
        }
        if($grade_id)
        {
            $sql .= " and grade_id = '$grade_id'";
        }

        $kindergarten = Kindergarten::whereRaw($sql)->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $data = array('title' => '点位管理','kList'=>$kindergarten);
        $data['name'] = $name;
        $data['type'] = $type;
        $data['province_id'] = $province_id;
        $data['city_id'] = $city_id;
        $data['area_id'] = $area_id;
        $data['grade_id'] = $grade_id;
        $kindergartenGradeList = KindergartenGrade::lists('kindergarten_grade','id');
        $provinceList = Province::orderBy('id')->lists('province','id');
        $cityList = City::orderBy('id')->lists('city_name','id');
        $areaList = Area::orderBy('id')->lists('area','id');
        $data['kindergartenGradeList'] = $kindergartenGradeList;
        $data['provinceList'] = $provinceList;
        $data['cityList'] = $cityList;
        $data['areaList'] = $areaList;
        return View::make('install.index',$data);
    }

    protected  function generateKID()
    {
        return Kindergarten::max('id')+1;
    }
    public function add()
    {
        $step = Input::get('step','1');
        $id   = $kid = $cid = $eid = $mid = '';
        $id   = Input::get('id','');
        $kid  = Input::get('kid','');
        $eid  = Input::get('eid','');
        $mid  = Input::get('mid','');
        if(Request::getMethod()=='POST')
        {

            $arr  = Input::all();
            $arr['author_id'] = Auth::user()->id;
            $rs   = '';
            if($step=="1")
            {
                if($id)
                {
                    $kid = $id;
                    $rs = Kindergarten::find($id)->update($arr);
                }else{
                    $arr['id'] = $this->generateKID();
                    $kid = $arr['id'];
                    $rs = Kindergarten::create($arr);
                }
            }

            if(!$kid)
            {
                $data['flag'] = 'error';
            }else{
                $arr['kid'] = $kid;
                if($step=="2")
                {
                    $kindergartenContact = new KindergartenContact();
                    $kindergartenContact->where('kid','=',$kid)->delete();
                    $contact_name_arr = Input::get('contact_name');
                    $qq_arr = Input::get('qq');
                    $mobile_arr = Input::get('mobile');
                    foreach($contact_name_arr as $key => $val)
                    {
                        $arr['type'] = $key + 1;
                        $arr['contact_name'] = $contact_name_arr[$key];
                        $arr['qq'] = $qq_arr[$key];
                        $arr['mobile'] = $mobile_arr[$key];
                        $rs = KindergartenContact::create($arr);
                        $arr['type'] = $arr['contact_name'] = $arr['qq'] = $arr['mobile'] = '';
                    }
                }
            }

            return Redirect::to('/install/add?id='.$kid.'&step='.$step);
        }
        $kindergartenGradeList = KindergartenGrade::lists('kindergarten_grade','id');

        $provinceList = Province::orderBy('id')->lists('province','id');
        $cityList = City::orderBy('id')->lists('city_name','id');
        $areaList = Area::orderBy('id')->lists('area','id');


        $assessmentList = Assessment::lists('assessment','id');
        $mediaAttrList = MediaAttr::lists('media_attr','id');

        $data['title']     = '添加点位';
        $data['step']      = $step;
        $data['assessmentList'] = $assessmentList;
        $data['kindergartenGradeList'] = $kindergartenGradeList;
        $data['mediaAttrList'] = $mediaAttrList;
        $data['provinceList'] = $provinceList;
        $data['cityList'] = $cityList;
        $data['areaList'] = $areaList;
        $data['position'] = Position::lists('position_name','id');
        $data['equipment_status_list'] = array(
            ''  => '请选择',
            '1' => '未安装',
            '2' => '已完工',
            '3' => '需维护',
            '4' => '拆卸',
        );
        //初始化对象
        $kindergarten = Kindergarten::find($id);
        $data['kindergarten']  = $kindergarten;
        $data['act'] = Input::get('act','');
        return View::make('install.add',$data);
    }

    /**
     * @todo 渠道维护
     * @author Justin.Bj@msn.com
     * @since $id
     * @return mixed
     */
    public function maintain()
    {
        $data['kid'] = Input::get('kid','');
        $arr = Input::all();
        $data['maintain_person'] = Auth::user()->truename;
        if(Request::getMethod()=='POST')
        {
            $arr['maintain_time'] = date('Y-m-d',time());
            $arr['next_maintain_time'] = date('Y-m-d',time()+ 20 * 24 * 3600);
            $rs = Maintain::create($arr);
            if($rs)
            {
                return Redirect::to('/install/maintainList');
            }

        }
        return View::make('install.add-maintain',$data);
    }

    public function maintainList()
    {
        $sql = ' 1=1 ';
        $kid = Input::get('kid','');
        if($kid)
        {
            $sql .= " and kid='$kid'";
        }
        $maintainList = Maintain::whereRaw($sql)->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $data = array('title' => '点位管理','maintainList'=>$maintainList,'kid'=>$kid);
        return View::make('install.maintainList',$data);
    }

    public function show($id)
    {
        $kindergartenGradeList = KindergartenGrade::lists('kindergarten_grade','id');
        $provinceList = Province::orderBy('id')->lists('province','id');
        $cityList = City::orderBy('id')->lists('city_name','id');
        $areaList = Area::orderBy('id')->lists('area','id');
        $assessmentList = Assessment::lists('assessment','id');
        $mediaAttrList = MediaAttr::lists('media_attr','id');

        $data['title']     = '添加点位';
        $data['assessmentList'] = $assessmentList;
        $data['kindergartenGradeList'] = $kindergartenGradeList;
        $data['mediaAttrList'] = $mediaAttrList;
        $data['provinceList'] = $provinceList;
        $data['cityList'] = $cityList;
        $data['areaList'] = $areaList;
        $data['position'] = Position::lists('position_name','id');
        $data['equipment_status_list'] = config::get('custom.EQUIPMENT_STATUS_LIST');
        //初始化对象
        $kindergarten = Kindergarten::find($id);
        $data['kindergarten']  = $kindergarten;
        $data['act'] = Input::get('act','');
        return View::make('install.show',$data);
    }

}
