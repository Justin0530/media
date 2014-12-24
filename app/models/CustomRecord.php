<?php

class CustomRecord extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'custom_record';
    protected $guarded = array('created_at','updated_at');
    protected $fillable = array(
        'id',
        'custom_id',
        'remark',
        'next_visit_time',
        'visit_time',
        'visitor',
        'author_id',
    );

    public function custom()
    {
        return $this->belongsTo('Custom');
    }

}
