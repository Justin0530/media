<?php

class Maintain extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'channel_maintain';
    protected $guarded = array('created_at','updated_at','deleted_at');
    protected $softDelete = true;
    protected $fillable = array(
        'id',
        'kid',
        'gift',
        'communication',
        'activies',
        'promotion',
        'english_ad',
        'examine',
        'is_maintain',
        'k_frame',
        'ad_frame',
        'maintain_time',
        'next_maintain_time',
        'maintain_person',
        'remark',
        'author_id',
    );

    public function kindergarten()
    {
        return $this->belongsTo('Kindergarten','kid');
    }

}
