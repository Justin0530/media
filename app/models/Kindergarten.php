<?php

class Kindergarten extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'kindergarten';
    protected $guarded = array('created_at','updated_at','deleted_at');
    protected $softDelete = true;
    protected $rules = array
    (
        'name'           =>'required',
        'class_count'    => 'required',
        'children'       => 'required',
    );

    public function contacts()
    {
        return $this->hasMany('Kindergarten');
    }

    public function equipment()
    {
        return $this->hasOne('Equipment');
    }


}
