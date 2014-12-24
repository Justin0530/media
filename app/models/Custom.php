<?php

class Custom extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'custom';
    protected $guarded = array('created_at','updated_at');
    protected $fillable = array(
        'id',
        'custom_name',
        'place',
        'contacts',
        'mobile',
        'telephone',
        'frames',
        'erector',
        'installation_cost',
        'email',
        'address',
        'status',
        'next_visit_time',
        'attr',
        'author_id',
    );
    protected   $rules   = array
    (
        'custom_name'       => 'required|max:200',
        'contacts'          => 'required',
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

    public function frame()
    {
        return $this->hasMany('Frame');
    }

    public function record()
    {
        return $this->hasMany('CustomRecord');
    }

}
