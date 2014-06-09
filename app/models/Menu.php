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
    private   $rules   = array
    (
        'menu'       => 'required|max:30',
        'menu_url'   => 'required|max:50',
        'status'     => 'required',
        'author_id'  => 'required',
        'parent_id'  => 'required',
        'menu_grade' => 'required',
    );

    private $errors;

    public function author()
    {
        return $this->belongTo('User','author_id');
    }


}