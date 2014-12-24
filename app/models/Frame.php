<?php

class Frame extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'frames';
    protected $guarded = array('created_at','updated_at');
    protected $fillable = array(
        'equipment_num',
        'image_path',
        'image_type',
        'start_time',
        'end_time',
        'custom_type_id',
        'custom_id',
        'status',
        'pre_sale_id',
        'design_frame_id',
    );
    protected $rules = array
    (
        'city_name'=>'required',
    );

    public function setImageType($val)
    {
        if(!$val)
        {
            $this->image_type = $val;
        }
        else
        {
            $this->image_type = '1';
        }
    }
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
        return $this->hasOne('CustomType','id','custom_type_id');
    }

    public function preSale()
    {
        return $this->belongsTo('PreSale');
    }

    public function scopeLog($query,$equipment_num,$status)
    {

        if(!$frameID) $frameID = [];

        return $query->whereIn('id',$frameID);
    }
}
