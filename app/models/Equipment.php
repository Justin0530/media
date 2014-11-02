<?php

class Equipment extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'equipment';
    protected $guarded = array('created_at','updated_at');
    protected $fillable = array(
        'id',
        'kid',
        'equipment_num',
        'equipment_sort',
        'position_id',
        'frames',
        'install_method',
        'erector',
        'installation_cost',
        'makespan',
        'installation_supervisor',
        'construction_supervisor',
        'image_path',
        'equipment_status',
        'led_status_remark',
        'led_status',
        'frame_status_remark',
        'frame_status',
        'power_source_status_remark',
        'power_source_status',
        'remark',
        'reason',
        'author',
    );
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

    public function frame()
    {
        return $this->hasMany('Frame','equipment_num','equipment_num');
    }

    public function patrolRecord()
    {
        return $this->hasMany('PatrolRecord','equipment_num','equipment_num');
    }

}
