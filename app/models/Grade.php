<?php

class Grade extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'grade';
    protected $guarded = array('created_at','updated_at','deleted_at');
    private $rules = array
    (
        'grade_name'=>'required|max:30',
        'status'    => 'integer',
        'desc'      => 'required',
    );
    protected $errors;
    public function author()
    {
        return $this->belongsTo('User','author_id');
    }
	public function menu()
    {
        return $this->hasMany('Menu');
    }

}
