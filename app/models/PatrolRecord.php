<?php

class PatrolRecord extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'patrol_record';
    protected $guarded = array('created_at','updated_at');
    protected $fillable = array(
        'id',
        'equipment_num',
        'patroler',
        'patrol_type',
        'remark',
        'patrol_time',
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

    public function equipment()
    {
        return $this->belongsTo('equipment','equipment_num','equipment_num');
    }
}
