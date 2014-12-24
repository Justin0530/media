<?php

class Province extends Eloquent
{
    protected $fillable = array();
    protected $table = 'province';


    public static $admin_config = array(
        'title'             => '省/直辖市维护',
        'description'       => '省/直辖市维护',
        'router'            => '/province',
        'next_router'       => '/city',
        'router_controller' => 'ProvinceController',
        'items'             => array(
            'id'            => array(
                'title'     => '编号',
                'type'      => 'string',
                'validator' => '',
                'attribute' => FORM_TYPE_ATTRIBUTE_LIST,
                ),
            'province'      => array(
                'title'     => '省/直辖市',
                'type'      => 'string',
                'validator' => 'required',
                'attribute' => '',
            ),
        ),
    );


}