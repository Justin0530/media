<?php

class Equipment extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'equipment';
    protected $guarded = array('created_at','updated_at');
    protected $rules = array
    (
        'equipment_num'=>'required',
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

    public function kindergarten()
    {
        return $this->belongsTo('Kindergarten','kid');
    }
	public function author()
    {
        return $this->belongsTo('User','author_id');
    }

    
}
