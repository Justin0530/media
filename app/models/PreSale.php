<?php

class PreSale extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pre_sale';
    protected $guarded = array('created_at','updated_at');
    protected $fillable = array(
        'trade_num',
        'custom_id',
        'custom_type_id',
        'province_id',
        'city_id',
        'area_id',
        'equipment_num',
        'start_time',
        'end_time',
        'pre_sale_id',
        'author_id',
    );
    protected $rules = array
    (
        'city_name'=>'required',
    );

    public function equipment()
    {
        return $this->belongsTo('Equipment','eid');
    }

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

    public function customType()
    {
        return $this->belongsTo('CustomType');
    }

    public function frames()
    {
        return $this->hasMany('Frame')->where('image_type','=','1');
    }

    public function author()
    {
        return $this->belongsTo('User','author_id');
    }

    public function province()
    {
        return $this->belongsTo('Province','province_id');
    }

    public function city()
    {
        return $this->belongsTo('City','city_id');
    }

    public function area()
    {
        return $this->belongsTo('Area','area_id');
    }

    public function custom()
    {
        return $this->belongsTo('Custom');
    }
}
