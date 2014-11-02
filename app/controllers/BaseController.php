<?php

class BaseController extends Controller {

    public $pageSize = '20';
    protected $layout = 'layout.layout';
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}

	}

    public function __construct()
    {
        $pageSize = Config::get('app.pageSize');
        $menu = Session::get('menu');
        if(!$menu)  $this->common();
        if($pageSize)
        {
            $this->pageSize = $pageSize;
        }
        $urlArr = Request::segments();
        $uri = current($urlArr);

        if($uri)
        {
            $currentMenuInfo = Menu::where('menu_url','like','/'.$uri.'%')->first();
            if(is_object($currentMenuInfo)&&$currentMenuInfo->parent_id)
                Session::set('parent_menu_id',$currentMenuInfo->parent_id);
        }
        if(count($urlArr))
        {
            $fullUri = '/'.implode('/',$urlArr);
            $currentSubMenuInfo = Menu::where('menu_url','like',$fullUri.'%')->first();
            if(is_object($currentSubMenuInfo)&&$currentSubMenuInfo->id)
            {
                Session::set('sub_menu_id',$currentSubMenuInfo->id);
            }
        }


    }

    public function common()
    {
        $menuList = array();
        try{
            $userId = Auth::user()->id;
        }
        catch (Exception $e)
        {
            return Redirect::to('login');
        }
        //grade()->get()->toArray();
        $gradeId = Auth::user()->grade_id;

        if(!$gradeId) return $menuList;

        $grade = Grade::find($gradeId);

        if(!$grade) return $menuList;
        $gradeType = $grade->range;
        if($grade)
        {
            $gradeType = $grade['range'];
        }
        if($gradeType == GRADE_TYPE_ALL)
        {
            //全部权限
            $menuList = Menu::where('status','=',MENU_STATUS_ENABLE)->get()->toArray();
        }
        else
        {
            //部分权限
            $menuIDList = GradeMenu::where('grade_id','=',$gradeId)->get()->toArray();
            foreach($menuIDList as $key => $val)
            {
                $tmpMenu = Menu::find($val['menu_id']);
                if(isset($tmpMenu) && $tmpMenu->status == MENU_STATUS_ENABLE)
                {
                    array_push($menuList,$tmpMenu->toArray());
                }

            }
        }

        return $this->menuSort($menuList);
    }

    protected function menuSort($menuList)
    {
        $first = $second = $third = array();
        if(is_array($menuList)&&count($menuList))
        {
            foreach($menuList as $key => $val)
            {
                if($val['menu_grade'] == MENU_GRADE_FIRST) array_push($first,$val);
                if($val['menu_grade'] == MENU_GRADE_SECOND) array_push($second,$val);
                if($val['menu_grade'] == MENU_GRADE_THIRD) array_push($third,$val);
            }
            Session::set('first',$first);
            Session::set('second',$second);
            Session::set('third',$third);

            foreach($second as $key => $val)
            {
                $tmp = array();
                foreach($third as $k => $v)
                {
                    if($v['parent_id']==$val['id']) array_push($tmp,$v);
                }
                $second[$key]['sub_menu'] = $tmp;
                unset($tmp);
            }

            foreach($first as $key => $val)
            {
                $tmp = array();
                foreach($second as $k => $v)
                {
                    if($v['parent_id']==$val['id']) array_push($tmp,$v);
                }
                $first[$key]['sub_menu'] = $tmp;
                unset($tmp);
            }
            Session::set('menu',$first);
        }

        return $first;

    }
}
