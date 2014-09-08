<?php

class Assessment extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'assessment';
    protected $guarded = array('created_at','updated_at','deleted_at');
    protected $softDelete = true;
    protected $rules = array
    (
        'grade_name'=>'required',
        'status'    => 'integer',
        'desc'      => 'required',
    );


}
