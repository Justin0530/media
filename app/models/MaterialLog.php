<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14-5-31
 * Time: 1:03
 */
class MaterialLog extends Base
{
    protected $fillable = [];
    protected $table = 'material_logs';

    public function equipment()
    {
        return $this->belongsTo('Equipment','eid');
    }

    public function material()
    {
        return $this->belongsTo('Material','mid');
    }

}