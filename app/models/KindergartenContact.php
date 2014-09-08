<?php

class KindergartenContact extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'kindergarten_contact';
    protected $guarded = array('created_at','updated_at','deleted_at');
    protected $softDelete = true;
    protected $rules = array
    (
        'grade_name'=>'required',
        'status'    => 'integer',
        'desc'      => 'required',
    );

    public function kindergarten()
    {
        return $this->belongsTo('Kindergarten', 'kid');
    }
}
