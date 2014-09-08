<?php

class City extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'city';
    protected $guarded = array('created_at','updated_at');
    protected $rules = array
    (
        'city_name'=>'required',
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
