<?php

class MediaController extends BaseController {

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
        $tradeNum = Input::get('trade_num','');
        $custom_name = Input::get('custom_name','');
        $type = Input::get('custom_id','');
        $custom_type_id = Input::get('custom_type_id');
        $province_id = Input::get('province_id','');
        $city_id = Input::get('city_id','');
        $area_id = Input::get('area_id','');

        if(Auth::User()->province_id) $province_id = Auth::User()->province_id;
        if(Auth::User()->city_id) $city_id = Auth::User()->city_id;
        if($tradeNum)
        {
            $sql .= " and trade_num = '$tradeNum'";
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
        if($area_id)
        {
            $sql .= " and area_id = '$area_id'";
        }
        if($custom_type_id)
        {
            $sql .= " and custom_type_id = '$custom_type_id'";
        }

        $preSaleList = PreSale::whereRaw($sql)->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $data = array('title' => '媒体管理','preSaleList'=>$preSaleList);
        $data['tradeNum'] = $tradeNum;
        $data['type'] = $type;
        $data['province_id'] = $province_id;
        $data['city_id'] = $city_id;
        $data['area_id'] = $area_id;
        $data['custom_name'] = $custom_name;
        $data['custom_type_id'] = $custom_type_id;

        $data['provinceList']  = Province::orderBy('id')->lists('province','id');
        $data['cityList']      = City::lists('city_name','id');
        $data['areaList']      = Area::lists('area','id');
        $data['customList']    = Custom::lists('custom_name','id');
        $data['customTypeList']= CustomType::lists('custom_type','id');
        return View::make('media.index',$data);
    }

    protected  function generateKID()
    {
        return Kindergarten::max('id')+1;
    }
    public function add()
    {
        $trade_id = Input::get('id','');
        if(Request::getMethod()=='POST')
        {

            $arr['custom_id'] = $img['custom_id'] = Input::get('custom_id');
            $arr['custom_type_id'] = $img['custom_type_id'] = Input::get('custom_type_id');
            $arr['province_id'] = Input::get('province_id','');
            $arr['city_id'] = Input::get('city_id','');
            $arr['area_id'] = Input::get('area_id','');
            $equipmentNumArr = Input::get('equipment_num');
            $arr['equipment_num'] = $img['equipment_num'] = '';
            if(count($equipmentNumArr))
            {
                $arr['equipment_num'] = $img['equipment_num'] = implode(',',$equipmentNumArr);
            }

            //$arr['counts'] = count(Input::file('image_path'));
            $arr['start_time'] = $img['start_time'] = strtotime(Input::get('start_time'));
            $arr['end_time'] = $img['end_time'] = strtotime(Input::get('end_time'));
            $arr['author_id'] = Auth::user()->id;

            if($trade_id)
            {
                $preSale = PreSale::find($trade_id)->update($arr);
            }else{
                $arr['trade_num'] = 'PRE'.date('YmdHis',time()).rand(1000,9999);
                $preSale = PreSale::create($arr);
                $trade_id = $preSale->id;
            }

            if(!is_object($preSale)) $preSale = PreSale::find($trade_id);
            if (Input::hasFile('image_path')||$trade_id)
            {
                $file = Input::file('image_path');
                $fileID = Input::get('image_path_id');
                $imageCounts = count($file);
                foreach($file as $key => $val)
                {
                    if(is_object($val))
                    {
                        $ext = $val->guessClientExtension();
                        $filename = $val->getClientOriginalName();
                        $dir_path = date('Ymd');
                        $val->move(public_path().'/data/'.$dir_path, md5(date('YmdHis').$filename).'.'.$ext);
                        $img['image_path'] = '/data/'.$dir_path.'/'.md5(date('YmdHis').$filename).'.'.$ext;
                    }
                    $img['image_type'] = '1';
                    $img['pre_sale_id'] = $trade_id;
                    $tmpFileID = isset($fileID[$key])?$fileID[$key]:'';

                    if($tmpFileID)
                    {
                        Frame::where('id','=',$tmpFileID)->update($img);
                    }
                    else
                    {
                        Frame::create($img);
                        $frame = Frame::where('image_path','=',$img['image_path'])->first();
                        $tmpFileID = $frame->id;
                    }

                    foreach($equipmentNumArr as $k => $v)
                    {
                        $log['equipment_num'] = $v;
                        $log['frame_id'] = $tmpFileID;
                        $frameLogObj = FrameLog::where("equipment_num","=",$v)
                            ->where("frame_id","=",$tmpFileID)->first();

                        if(is_object($frameLogObj) && $frameLogObj->id)
                        {
                            //
                        }
                        else
                        {
                            $log['status'] = '1';
                            FrameLog::create($log);
                        }
                    }

                }
                if($imageCounts)
                {
                    $preSale->counts = $imageCounts;
                    $preSale->save();
                }

            }
            return Redirect::to('/media/index');
        }

        $data['title']         = '预售点位';
        $data['provinceList']  = Province::orderBy('id')->lists('province','id');
        $data['cityList']      = City::orderBy('id')->lists('city_name','id');
        $data['areaList']      = Area::orderBy('id')->lists('area','id');
        $data['customList']    = Custom::lists('custom_name','id');
        $data['customTypeList']= CustomType::lists('custom_type','id');
        $data['equipmentList'] = Equipment::where('equipment_status','=','2')
            //->where('led_status','=','1')
            //->where('frame_status','=','1')
            //->where('power_source_status','=','1')
            ->lists('equipment_num','equipment_num');

        $preSale = PreSale::find($trade_id);
        if(!$preSale) $preSale = new PreSale();
        $data['preSale']       = $preSale;
        return View::make('media.add',$data);
    }



}
