<?php

class Area extends Eloquent
{
    protected $fillable = [];
    protected $table = 'area';


    public static $admin_config = [
        'title'             => '区/县',
        'description'       => '区/县',
        'router'            => '/area',
        'router_controller' => 'AreaController',
        'items'             => [
            'id'           => [
                'title'    => '编号',
                'type'     => 'string',
                'validator'=> '',
                'attribute'=> FORM_TYPE_ATTRIBUTE_LIST,
            ],
            'area'     => [
                'title'     => '区/县',
                'type'      => 'string',
                'validator' => 'required',
                'attribute' => '',
            ],
        ],
    ];


}