<?php

class Maintain extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'maintain';
    protected $guarded = array('created_at','updated_at','deleted_at');
    protected $softDelete = true;



}
