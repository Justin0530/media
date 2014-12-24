<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14-6-30
 * Time: 22:30
 */

/*
|--------------------------------------------------------------------------
| 自定义脚本
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/
function kStatus($value)
{
    $arr = array(
        '1'=>'未安装',
        '2'=>'已完工',
        '3'=>'需维护',
        '4'=>'拆卸',
    );
    return isset($arr[$value])?$arr[$value]:$value;
};

function patrol_status($value)
{
    $arr = array(
        '1'=>'上画',
        '2'=>'巡查',
        '3'=>'维修',
    );
    return isset($arr[$value])?$arr[$value]:$value;
}

function custom_type($val)
{
    $arr = array(
        '1' => '直客',
        '2' => '4A广告公司',
    );
    return isset($arr[$val])?$arr[$val]:$val;
}

function custom_status($val)
{
    $status = array(
        ''  =>  '请选择',
        '1' =>  '有意向',
        '2' =>  '已保价',
        '3' =>  '已签约',
        '4' =>  '未联系',
    );
    return isset($status[$val])?$status[$val]:$val;
}

function msg_status($val)
{
    $status = array(
        ''  =>  '',
        '1' =>  '消息',
        '2' =>  '任务',
    );
    return isset($status[$val])?$status[$val]:$val;
}
