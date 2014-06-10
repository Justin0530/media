<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14-5-31
 * Time: 1:03
 */
class Menu extends Base
{
    protected $table = 'menu';
    protected $guarded = array('created_at','updated_at','deleted_at');
    protected   $rules   = array
    (
        'menu'       => 'required|max:30',
        'menu_url'   => 'required|max:200',
        'status'     => 'required',
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
        return $this->belongTo('User','author_id');
    }

    public function parent()
    {
        return $this->belongTo('Menu','parent_id');
    }


}