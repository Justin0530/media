<?php

class CustomType extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'custom_type';
    protected $guarded = array('created_at','updated_at');
    protected $fillable = array(
        'custom_type',
        'status',
    );
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

    public function preSale()
    {
        return $this->hasMany('PreSale');
    }
}
