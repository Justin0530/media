<?php

class CommonController extends CrudController {

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
        return 'index';
    }

    public function getDataList()
    {
        $Model = Input::get('model','');
        $father_id = Input::get('father','');
        if($Model)
        {
            $column = 'city_name';
            if($Model=='Area') $column = 'area';
            $list = $Model::where('father','=',$father_id)->get()->lists($column,'id');
            return $list;
        }
        else
        {
            return 'test';
        }
    }

    public function getEInfoList()
    {
        $province_id = Input::get('province_id','');
        $city_id = Input::get('city_id','');
        $area_id = Input::get('area_id');
        $sql = '1=1 ';
        $sqlArr = array();
        if($province_id)
        {
            $sql .= ' and province_id= ? ';
            $sqlArr[] = $province_id;
        }
        if($city_id)
        {
            $sql .= ' and city_id = ? ';
            $sqlArr[] = $city_id;
        }
        if($area_id)
        {
            $sql .= ' and area_id = ? ';
            $sqlArr[] = $area_id;
        }
        $kidList = Kindergarten::whereRaw($sql,$sqlArr)->get()->lists('id');
        if(count($kidList))
        {
            $eInfoList = Equipment::whereIn('kid',$kidList)
                //->where('led_status','=','1')
                //->where('frame_status','=','1')
                //->where('power_source_status','=','1')
                ->lists('equipment_num');
        }
        else
        {
            $eInfoList = '';
        }

        return $eInfoList?json_encode($eInfoList):"";
    }

    public function frame()
    {
        $equipment_num = Input::get('equipment_num','');
        $frame_id = Input::get('frame_id','');
        $status = Input::get('status','');
        if(!$equipment_num||!$frame_id||!$status)
        {
            return '参数为空，请重试~';
        }
        $equipmentObj = Equipment::where('equipment_num','=',$equipment_num)->first();
        $frames = $equipmentObj->frames;
        $frameLogObj = FrameLog::where('equipment_num','=',$equipment_num);
        if($status=='2')
            $frameLogObj->where('status','=',$status);
        $frameLogList = $frameLogObj->get();

        if(count($frameLogList)>=$frames&&$status=='2')
        {
            return Response::json('当前设备画面已满，请先下刊画面再上刊新画面');
        }
        else
        {
            $data['status'] = $status;
            FrameLog::where('equipment_num','=',$equipment_num)
                ->where('frame_id','=',$frame_id)->update($data);
            return Response::json('');
        }
    }
}
