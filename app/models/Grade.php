<?php

class Grade extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'grade';
    protected $guarded = array('created_at','updated_at','deleted_at');
    protected $rules = array
    (
        'grade_name'=>'required',
        'status'    => 'integer',
        'desc'      => 'required',
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
	public function menu()
    {
        return $this->hasMany('Menu');
    }

    public function gradeMenu()
    {
        return $this->hasMany('GradeMenu');
    }

}
