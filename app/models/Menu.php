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
        return $this->belongsTo('User','author_id');
    }

    public function menus()
    {
        return $this->hasMany('Menu');
    }

    public function parent()
    {
        return $this->belongsTo('Menu','parent_id');
    }


}