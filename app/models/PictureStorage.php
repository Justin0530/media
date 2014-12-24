<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14/11/8
 * Time: 11:44
 */

class PictureStorage extends Base {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'picture_storage';
    protected $guarded = array('created_at','updated_at');
    protected $rules = array
    (
        'image_path'=>'required',
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
} 