<?php

class MediaAttr extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'media_attr';
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

}
