<?php
/**
 * @todo model基础类 提供通用方法
 * @author: justin
 * Date: 14-5-31
 * Time: 1:15
 */

class Base extends Eloquent
{
    private $errors;

    public function validate($data,$rules)
    {
        $v = Validator::make($data, $rules);
        if($v->fails())
        {
            $this->errors = $v;
            return false;
        }
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
} 