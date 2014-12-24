<?php

class EquipmentController extends BaseController {

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
        $sql = '1=1';
        $sqlArr = array();
        $name = Input::get('name','');
        $type = Input::get('type','');
        $city_id = Input::get('city_id','');
        $grade_id = Input::get('grade_id');
        if($name)
        {
            $sql .= " and name like '%$name%'";
        }
        if($type)
        {
            $sql .= " and type = '$type'";
        }
        if($city_id)
        {
            $sql .= " and city_id = '$city_id'";
        }
        if($grade_id)
        {
            $sql .= " and grade_id = '$grade_id'";
        }

        $kindergarten = Kindergarten::whereRaw($sql)->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $data = array('title' => '点位管理','kList'=>$kindergarten);
        $data['name'] = $name;
        $data['type'] = $type;
        $data['city_id'] = $city_id;
        $data['grade_id'] = $grade_id;
        $kindergartenGradeList = KindergartenGrade::lists('kindergarten_grade','id');
        $cityList = City::lists('city_name','id');
        $data['kindergartenGradeList'] = $kindergartenGradeList;
        $data['cityList'] = $cityList;
        return View::make('install.index',$data);
    }

    /**
     * @todo 管理搜索页面初始化
     * @author Justin.bj@msn.com
     * @return mixed
     */
    public function select(){
        $equipment_num = Input::get('equipment_num','');
        $province_id = Input::get('province_id','');
        $city_id = Input::get('city_id','');
        $area_id = Input::get('area_id','');

        if(Auth::User()->province_id) $province_id = Auth::User()->province_id;
        if(Auth::User()->city_id) $city_id = Auth::User()->city_id;

        $provinceList = Province::orderBy('id')->lists('province','id');
        $cityList = City::orderBy('id')->lists('city_name','id');
        $areaList = Area::orderBy('id')->lists('area','id');
        $eArray = array();
        if(Input::getMethod()=='POST')
        {
            if($province_id||$city_id||$area_id)
            {
                $objK = Kindergarten::select('id');
                if($province_id) $objK->where('province_id','=',$province_id);
                if($city_id) $objK->where('city_id','=',$city_id);
                if($area_id) $objK->where('area_id','=',$area_id);
                $kidList = $objK->get()->lists('id');
                if(count($kidList))
                {
                    if($equipment_num)
                    {
                        $tmp = Equipment::whereIn('kid',$kidList)
                            ->where('equipment_num','=',$equipment_num)->get();
                        if (count($tmp)) $eArray = $tmp;
                    }else{

                        $tmp = Equipment::whereIn('kid',$kidList)->get();
                        if (count($tmp)) $eArray = $tmp;
                    }
                }

            }else{
                if($equipment_num)
                {
                    $eArray = Equipment::where('equipment_num','=',$equipment_num)->get();
                }
                else
                {
                    $eArray = Equipment::get();
                }
            }
        }
        $data['provinceList'] = array('0'=>'请选择省/直辖市') + $provinceList;
        $data['cityList'] = array('0'=>'请选择城市') + $cityList;
        $data['areaList'] = array('0'=>'请选择区/县') + $areaList;
        $data['equipment_num'] = $equipment_num;
        $data['province_id']   = $province_id;
        $data['city_id']       = $city_id;
        $data['area_id']       = $area_id;
        $data['title']         = '运维管理';
        $data['eArray']        = $eArray;
        return View::make('equipment.index',$data);
    }

    /**
     * @todo 管理设备画面信息、
     * @author Justin.bj@msn.com
     * @version $id
     * @param $id
     * @return mixed
     */
    public function manager($id)
    {
        $data = array();
        $step = Input::get('step','1');
        $equipment = Equipment::find($id);

        if(Request::getMethod()=='POST')
        {
            $arr = Input::all();
            if($step=='2')
            {
                unset($arr['eid']);
                unset($arr['step']);
                if($arr['led_status']=='2'||$arr['frame_status']=='2'||$arr['power_source_status']=='2')
                {
                    $arr['equipment_status'] = '3';
                }else{
                    $arr['equipment_status'] = '2';
                }
                $equipment->where('id','=',$id)->update($arr);
            }
            if($step=='3')
            {
                $arr['equipment_num'] = $equipment->equipment_num;
                $arr['patrol_time'] = strtotime($arr['patrol_time']);
                PatrolRecord::create($arr);
            }
        }

        $data['equipment'] = $equipment;
        //巡查记录
        $patrolRecord = PatrolRecord::where('equipment_num','=',$equipment->equipment_num)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate($this->pageSize);
        $data['patrolRecord'] = $patrolRecord;

        /**  当前画面 旧算法 */
//        $frameID = FrameLog::where('equipment_num','=',$equipment->equipment_num)
//            ->where('status','=','2')->get()->lists('frame_id');
//        $nowFrames = [];
//        if(count($frameID))
//            $nowFrames = Frame::whereIn('id',$frameID)-

        /**  当前画面 新算法 */
        $nowFrames = Frame::where('image_type','=','2')
            //->where('status','=','1')
            ->where('equipment_num','like','%'.$equipment->equipment_num.'%')
            ->orderBy('created_at', 'desc')->limit($equipment->frames)
            ->get();


        /** 预售画面 旧算法 */
        $wFrameID= FrameLog::where('equipment_num','=',$equipment->equipment_num)
            ->where('status','=','1')->get()->lists('frame_id');
        $willFrames = [];
        if(count($wFrameID))
            $willFrames = Frame::whereIn('id',$wFrameID)->get();

        /** 预售画面 新算法
        $willFrames = Frame::where('image_type','=','1')
            ->where('status','<>','2')
            ->where('equipment_num','like','%'.$equipment->equipment_num.'%')
            ->where('start_time','<',(time()+DEEL_WITH_LENGH_DAY*24*360))
            ->where('end_time','>',time())->get();*/

        $data['title'] = '运维管理';
        $data['step'] = $step;
        $data['id']   = $id;

        $data['nowFrames'] = $nowFrames;
        $data['willFrames'] = $willFrames;
        return View::make('equipment.manager',$data);
    }

    /**
     * @todo 维修列表
     * @author Justin.W
     * @since
     * @return mixed
     */
    public function maintain()
    {
        $sql = '1=1';
        $sqlArr = array();
        $name = Input::get('name','');

        $province_id = Input::get('province_id','');
        $city_id = Input::get('city_id','');
        $area_id = Input::get('area_id','');
        $grade_id = Input::get('grade_id');

        if(Auth::User()->province_id) $province_id = Auth::User()->province_id;
        if(Auth::User()->city_id) $city_id = Auth::User()->city_id;

        if($name)
        {
            $sql .= " and name like '%$name%'";
        }

        if($province_id)
        {
            $sql .= " and province_id = '$province_id'";
        }
        if($city_id)
        {
            $sql .= " and city_id = '$city_id'";
        }
        if($area_id)
        {
            $sql .= " and area_id = '$area_id'";
        }
        if($grade_id)
        {
            $sql .= " and grade_id = '$grade_id'";
        }
        $kindergartenList = Kindergarten::whereHas('equipment', function($q)
        {
            $q->where('equipment_status', '=', '3');

        })->whereRaw($sql)->orderBy('updated_at', 'desc')->paginate($this->pageSize);;
        //$kindergartenList = Kindergarten::
        $data = array('title' => '维修列表','maintain'=>$kindergartenList);
        $data['name'] = $name;
        $data['province_id'] = $province_id;
        $data['city_id'] = $city_id;
        $data['area_id'] = $area_id;
        $provinceList = Province::orderBy('id')->lists('province','id');
        $cityList = City::orderBy('id')->lists('city_name','id');
        $areaList = Area::orderBy('id')->lists('area','id');
        $data['provinceList'] = array('0'=>'请选择省/直辖市') + $provinceList;
        $data['cityList'] = array('0'=>'请选择城市') + $cityList;
        $data['areaList'] = array('0'=>'请选择区/县') + $areaList;
        return View::make('equipment.maintain',$data);
    }
    protected  function generateKID()
    {
        return Kindergarten::max('id')+1;
    }

    /**
     * @todo 备份添加点位
     * @author Justin.bj@msn.com
     * @return mixed
     */
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

            return Redirect::to('/install/add?id='.$kid.'&step='.$step)->with('flag',$flag);
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
     * @todo 更换物料(打开物料页面)
     * @author Justin.Bj@msn.com
     * @param $kid
     * @return mixed
     */
    public function changeMaterial($kid)
    {
        $class = 'Material';
        $sql = '1=1';
        $sqlArr = array();
        if(!$kid)
        {
            return Redirect::intended();
        }
        $name = Input::get('name','');
        $province_id = Session::get('province_id')?Session::get('province_id'):Input::get('province_id','');
        $city_id = Session::get('city_id')?Session::get('city_id'):Input::get('city_id','');
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
        $template = 'equipment.change_material';
        $provinceList = Province::select(['id','province'])->get()->lists('province','id');
        $cityList = City::select(['id','city_name'])->get()->lists('city_name','id');
        return View::make($template, [
            'page'         => [],
            'title'        => '更换材料',
            'data'         => $data,
            'config'       => $admin_config,
            'provinceList' => $provinceList,
            'cityList'     => $cityList,
            'keyword'      => $name,
            'province_id'  => $province_id,
            'city_id'      => $city_id,
            'kid'          => $kid,
        ]);
    }

    /**
     * @todo 更换物料 AJAX 修改物料数量，记录日志或发布补仓消息
     * @author Justin.Bj@msn.com
     * @param $mid
     * @return mixed
     */
    public function changeMaterialAjax($mid)
    {
        $eid = Input::get('eid','');
        $num = Input::get('num','');
        if($eid && $mid && $num)
        {
            $materialObj = Material::find($mid);
            $equipmentObj = Equipment::find($eid);
            if($materialObj->num>=$num)
            {
                $materialObj->num = $materialObj->num - $num;
                $materialObj->save();
                $materialLogObj = new MaterialLog();
                $materialLogObj->mid = $mid;
                $materialLogObj->eid = $eid;
                $materialLogObj->num = $num;
                $materialLogObj->equipment_num = $equipmentObj->equipment_num;
                $materialLogObj->save();
                return Response::json('10000');
            }
            else
            {
                $province = isset($equipmentObj->kindergarten->province->province)?$equipmentObj->kindergarten->province->province:'';
                $city = isset($equipmentObj->kindergarten->city->city_name)?$equipmentObj->kindergarten->city->city_name:'';
                //$area = isset($equipmentObj->kindergarten->area->area)?$equipmentObj->kindergarten->area->area:'';
                $msg =  $province . $city;
                $msg .= " ".$materialObj->name . "缺货，请及时调拨或者采购。请知悉！";
                $message = new Message();
                $message->type = '1';
                $message->message = $msg;
                $message->recevier = '运营总监';
                $message->status = '0';
                $message->save();
                return Response::json('10002');
            }
        }
        else
        {
            return Response::json('10001');
        }
    }

    public function deelList()
    {
        $province_id = Input::get('province_id','');
        $city_id = Input::get('city_id','');
        $area_id = Input::get('area_id','');
        $days = Input::get('days',DEEL_WITH_LENGH_DAY);

        if(Auth::User()->province_id) $province_id = Auth::User()->province_id;
        if(Auth::User()->city_id) $city_id = Auth::User()->city_id;
        $provinceList = Province::orderBy('id')->lists('province','id');
        $cityList = City::orderBy('id')->lists('city_name','id');
        $areaList = Area::orderBy('id')->lists('area','id');


        $data['provinceList'] = array('0'=>'请选择省/直辖市') + $provinceList;
        $data['cityList'] = array('0'=>'请选择城市') + $cityList;
        $data['areaList'] = array('0'=>'请选择区/县') + $areaList;
        $data['province_id'] = $province_id;
        $data['city_id'] = $city_id;
        $data['area_id'] = $area_id;
        return View::make('equipment.maintain',$data);
    }

    public function deelWith($frameID='')
    {
        $frameID = Input::get('frameID',$frameID);
        $eNum = Input::get('eNum');
        if(!$frameID||!$eNum)
        {

            return Redirect::back();
        }
        $frame = Frame::find($frameID);
        $eid = Equipment::where('equipment_num','=',$eNum)->pluck('id');
        if(Request::getMethod()=='POST')
        {
            $file = Input::file('image_path');
            if($file->isValid())
            {
                $ext = $file->guessClientExtension();
                $filename = $file->getClientOriginalName();
                $dir_path = date('Ymd');
                $file->move(public_path().'/data/'.$dir_path, md5(date('YmdHis').$filename).'.'.$ext);
                $image_path = '/data/'.$dir_path.'/'.md5(date('YmdHis').$filename).'.'.$ext;
                $new = $frame->toArray();
                $new['image_path'] = $image_path;
                $new['image_type'] = '2';
                $new['design_frame_id'] = $frame->id;
                $new['equipment_num'] = $eNum;
                unset($new['id']);
                Frame::create($new);
                return Redirect::to(URL::action('EquipmentController@manager',[$eid]));
            }
        }
        $data['frameID'] = $frameID;
        $data['eNum'] = $eNum;
        return View::make('equipment.deel',$data);

    }

}
