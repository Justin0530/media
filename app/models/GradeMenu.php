<?php

class GradeMenu extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'grade_menu';
    protected $guarded = array('created_at','updated_at');
    private $rules = array
    (
        'grade_id'   =>'required',
        'menu_id'    => 'required'
    );
    protected $errors;

    public function grade()
    {
        return $this->belongsTo('Grade','grade_id');
    }

	public function menu()
    {
        return $this->belongsTo('Menu','menu_id');
    }

}
