<?php

class ProjectController extends BaseController {

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

	public function getIndex()
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
        return View::make('project.index',$data);
    }

    protected  function generateKID()
    {
        return Kindergarten::max('id')+1;
    }

    public function getEquipment()
    {
        $kid = Input::get('kid','');
        if(!$kid)
        {
            return Redirect::intended();
        }
        $kindergartenInfo = Kindergarten::find($kid);
        if(Request::getMethod()=='POST')
        {
            $arr = Input::all();
            $reasonArr = Input::get('reason');
            if(count($reasonArr))
                $arr['reason'] = implode('|',$reasonArr);
            $id = Input::get('id','');
            if (Input::hasFile('image_path'))
            {
                $id = Input::get('id','');
                $file = Input::file('image_path');
                $ext = $file->guessClientExtension();
                $filename = $file->getClientOriginalName();
                $dir_path = date('Ymd');
                $file->move(public_path().'/data/'.$dir_path, md5(date('YmdHis').$filename).'.'.$ext);
                $arr['image_path'] = '/data/'.$dir_path.'/'.md5(date('YmdHis').$filename).'.'.$ext;
            }else{
                unset($arr['image_path']);
            }
            $arr['author'] = Auth::user()->truename;

            if($id)
            {
                $rs = Equipment::find($id)->update($arr);
            }else{
                $rs = Equipment::create($arr);
            }
            if($rs)
            {
                return Redirect::to('/project/index');
            }
        }
        $equipmentInfo = $kindergartenInfo->equipment;
        //var_dump($equipmentInfo);exit();
        $data['kindergarten'] = $kindergartenInfo;
        $data['equipment'] = $equipmentInfo;
        $data['kid'] = $kid;
        $data['position'] = Position::lists('position_name','id');
        $data['title'] = '确认设备安装';
        $data['equipment_status_list'] = Config::get('custom.EQUIPMENT_STATUS_LIST');
        $data['install_method_list'] = Config::get('custom.INSTALL_METHOD_LIST');
        return View::make('project.equipment',$data);
    }

    public function getAdd()
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
                if($step=="3")
                {
                    if (Input::hasFile('image_path'))
                    {
                        $file = Input::file('image_path');
                        $ext = $file->guessClientExtension();
                        $filename = $file->getClientOriginalName();
                        $dir_path = date('Ymd');
                        $file->move(public_path().'/data/'.$dir_path, md5(date('YmdHis').$filename).'.'.$ext);
                        $arr['image_path'] = '/data/'.$dir_path.'/'.md5(date('YmdHis').$filename).'.'.$ext;
                    }else{
                        unset($arr['image_path']);
                    }

                    if($eid)
                    {
                        $rs = Equipment::find($eid)->update($arr);
                    }else{
                        $rs = Equipment::create($arr);
                    }
                }
                if($step=="4")
                {
                    if($arr['maintain_time'] && $arr['maintain_status']=='1')
                        $arr['next_maintain_time'] = date('Y-m-d',strtotime($arr['maintain_time'])+ 20 * 24 * 3600);
                    if($mid)
                    {
                        $rs = Maintain::find($mid)->update($arr);
                    }else{
                        $rs = Maintain::create($arr);
                    }
                }

                $flag = '';
                if($rs)
                {
                    $flag = 'successful';
                }else{
                    $flag = 'error';
                }
            }

            return Redirect::to('/project/add?id='.$kid.'&step='.$step)->with('flag',$flag);
        }
        $kindergartenGradeList = KindergartenGrade::lists('kindergarten_grade','id');
        $cityList = City::lists('city_name','id');
        $assessmentList = Assessment::lists('assessment','id');
        $mediaAttrList = MediaAttr::lists('media_attr','id');

        $data['title']     = '添加点位';
        $data['step']      = $step;
        $data['assessmentList'] = $assessmentList;
        $data['kindergartenGradeList'] = $kindergartenGradeList;
        $data['mediaAttrList'] = $mediaAttrList;
        $data['cityList'] = $cityList;
        $data['position'] = Position::lists('position_name','id');
        $data['equipment_status_list'] = Config::get('custom.EQUIPMENT_STATUS_LIST');
        $data['install_method_list'] = Config::get('custom.INSTALL_METHOD_LIST');
        //初始化对象
        $kindergarten = Kindergarten::find($id);
        $data['kindergarten']  = $kindergarten;
        $data['act'] = Input::get('act','');
        return View::make('project.add',$data);
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
