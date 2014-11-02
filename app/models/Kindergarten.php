<?php

class Kindergarten extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'kindergarten';
    protected $guarded = array('created_at','updated_at','deleted_at');
    protected $fillable = array(
        'id',
        'name',
        'province_id',
        'city_id',
        'area_id',
        'region',
        'class_count',
        'children',
        'grade_id',
        'assessment_id',
        'tuition',
        'media_attr_id',
        'in_community',
        'community_name',
        'is_along',
        'street',
        'address',
        'env_desc',
        'signing_status',
        'pact_num',
        'pact_year',
        'signatory',
        'signing_time',
    );
    protected $softDelete = true;
    protected $rules = array
    (
        'name'           =>'required',
        'class_count'    => 'required',
        'children'       => 'required',
    );
    public function province()
    {
        return $this->belongsTo('Province');
    }
    public function city()
    {
        return $this->belongsTo('City');
    }
    public function area()
    {
        return $this->belongsTo('Area');
    }
    public function contacts()
    {
        return $this->hasMany('KindergartenContact','kid');
    }

    public function equipment()
    {
        return $this->hasOne('Equipment','kid');
    }

    public function maintain(){
        return $this->hasOne('Maintain','kid');
    }

    public function grade(){
        return $this->belongsTo('KindergartenGrade','grade_id');
    }


}
