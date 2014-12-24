<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14-5-31
 * Time: 1:03
 */
class Material extends Base
{
    protected $fillable = [];
    protected $table = 'material';


    public static $admin_config = [
        'parent_title'      => '运维管理',
        'title'             => '物料管理',
        'description'       => '物料信息维护',
        'router'            => '/material',
        'router_controller' => 'MaterialController',
        'template_index'    => 'material.index',
        'template_edit'     => 'material.edit',
        'items'             => [
            'id'        => [
                'title'     => '编号',
                'type'      => 'string',
                'validator' => '',
                'attribute' => FORM_TYPE_ATTRIBUTE_LIST,
            ],
            'material_cat_id'      => [
                'title'     => '物料分类',
                'type'      => 'select',
                'validator' => 'required',
                'attribute' => '',
                'select-items' =>[
                    0 => '请选择',
                ],
            ],
            'name'      => [
                'title'     => '物料名称',
                'type'      => 'string',
                'validator' => 'required',
                'attribute' => '',
            ],
            'province_id'      => [
                'title'     => '省/直辖市',
                'type'      => 'select',
                'func'      => 'cityOut(this,\'city_id\')',
                'select-items' => [
                    0 => '请选择',
                ],
                'validator' => 'required',
                'attribute' => '',
            ],
            'city_id'      => [
                'title'     => '城市',
                'type'      => 'select',
                'select-items' => [
                    0 => '请选择',
                ],
                'validator' => 'required',
                'attribute' => '',
            ],
            'total_num'      => [
                'title'     => '总数',
                'type'      => 'hidden',
                'validator' => 'required',
                'attribute' => '',
                'hidden'    => 'true',
            ],
            'num'      => [
                'title'     => '好',
                'type'      => 'string',
                'validator' => 'required',
                'attribute' => '',
            ],
            'error_num'      => [
                'title'     => '坏',
                'type'      => 'string',
                'validator' => 'required',
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
        'name'       => 'required|max:30',
        'province_id'       => 'required|max:30',
        'city_id'    => 'required',
        'num'        => 'required',
        'status'     => '',
    );

    /**
     * @param array $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }


    public function author()
    {
        return $this->belongsTo('User','author_id');
    }

    public function province()
    {
        return $this->belongsTo('Province');
    }

    public function city()
    {
        return $this->belongsTo('City');
    }

    public function parent()
    {
        return $this->belongsTo('Menu','parent_id');

    }

    public function gradeMenu()
    {
        return $this->hasMany('GradeMenu');
    }

    public function materialCat()
    {
        return $this->belongsTo('MaterialCat');
    }
}