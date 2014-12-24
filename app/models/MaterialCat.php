<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14-5-31
 * Time: 1:03
 */
class MaterialCat extends Base
{
    protected $fillable = [];
    protected $table = 'material_cat';


    public static $admin_config = [
        'parent_title'      => '系统管理',
        'title'             => '物料分类管理',
        'description'       => '物料分类信息维护',
        'router'            => '/materialCat',
        'router_controller' => 'MaterialCatController',
        'items'             => [
            'id'        => [
                'title'     => '编号',
                'type'      => 'string',
                'validator' => '',
                'attribute' => FORM_TYPE_ATTRIBUTE_LIST,
            ],
            'material_cat'      => [
                'title'     => '物料分类',
                'type'      => 'string',
                'validator' => 'required',
                'attribute' => '',
            ],
            'remark'      => [
                'title'     => '分类备注',
                'type'      => 'string',
                'validator' => '',
                'attribute' => '',
            ],
            'created_at'      => [
                'title'     => '创建时间',
                'type'      => 'string',
                'validator' => '',
                'attribute' => FORM_TYPE_ATTRIBUTE_LIST,
            ],
            'updated_at'      => [
                'title'     => '更新时间',
                'type'      => 'string',
                'validator' => '',
                'attribute' => FORM_TYPE_ATTRIBUTE_LIST,
            ],
        ],
    ];

    protected $rules   = array
    (
        'material_cat'      => 'required|max:30',
        'remark'           => '',
    );

}