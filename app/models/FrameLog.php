<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14-9-13
 * Time: 13:07
 */

class FrameLog extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'frames_log';
    protected $guarded = array('created_at','updated_at');
    protected $fillable = array(
        'equipment_num',
        'frame_id',
        'status',
        'remark'
    );
    protected $rules = array
    (
        'city_name'=>'required',
    );

    public function equipment()
    {
        return $this->belongsTo('Equipment','equipment_num','equipment_num');
    }

    public function frame()
    {
        return $this->belongsTo('Frame','frame_id');
    }

    /**
     * @param array $rules
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
    }
} 