<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14/11/16
 * Time: 14:11
 */

class Utils {

    public static function getFrameOper($equipmentNum)
    {
        $timePoint = time()+DEEL_WITH_LENGH_DAY * 24 * 3600;
        $arr = Frame::where('equipment_num','=',$equipmentNum)
            ->where('end_time','>',time())
            ->where('end_time','<',$timePoint)->get();
        if(is_array($arr)&&count($arr))
        {
            return '有画面在7天内到期';
        }
        return '';
    }

    public static function getEquipmentUseStatus($equipmentNum)
    {
        $isFree = Frame::where('image_type','=','2')
            ->where('equipment_num','=',$equipmentNum)
            ->where('start_time','<',time())
            ->where('end_time','>',time())->get()->toArray();
        if(is_array($isFree)&&count($isFree))
        {
            return '在用';
        }
        else
        {
            return '空闲';
        }
    }
} 