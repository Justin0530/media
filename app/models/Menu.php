<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14-5-31
 * Time: 1:03
 */
class Menu extends Base
{
    protected $table = 'menus';
    protected $guarded = array('created_at','updated_at','deleted_at');
    protected   $rules   = array
    (
        'menu'       => 'required|max:30',
        'status'     => 'required',
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


    public function author()
    {
        return $this->belongsTo('User','author_id');
    }



    public function parent()
    {
        return $this->belongsTo('Menu','parent_id');

    }

    public function gradeMenu()
    {
        return $this->hasMany('GradeMenu');
    }


    /**
     *
     * @todo 获取菜单分类 递归调用，递归的次数取决书$grade
     * @author Justin.BJ@msn.com
     * @param $grade 菜单的级别
     * @param $tree  菜单数组
     * @return array
     */
    public function getMenuTree($grade,$tree){

        $tmp = array();
        if($grade)
        {
            $list = DB::table($this->table)->where('status','=','1')->where('menu_grade','=',$grade)->get();
            if(is_array($tree)&&count($tree)>0)
            {
                foreach($list as $key => $val)
                {
                    $val = get_object_vars($val);
                    foreach($tree as $k => $v)
                    {
                        if($v['parent_id']==$val['id'])
                        {
                            $val['sub'][] = $v;
                        }
                    }
                    array_push($tmp,$val);
                }
                $tree = $tmp;
            }else{
                foreach($list as $key => $val)
                {
                    $val = get_object_vars($val);
                    array_push($tree,$val);
                }
            }
            $new_grade = $grade - 1;
            if($new_grade)
            {
                return $this->getMenuTree($new_grade,$tree);
            }else{
                return $tree;
            }
        }else{
            return $tree;
        }
    }
}