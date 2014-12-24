<?php

class CustomController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
    {
        //$menuList = Menu::with('author')->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $author_id = Auth::user()->id;
        $sql = ' author_id = '.$author_id;
        $custom_name = Input::get('custom_name','');
        $contacts = Input::get('contacts','');
        $status = Input::get('status','');
        if($custom_name)
        {
            $sql .= " and name like '%$custom_name%'";
        }

        if($contacts)
        {
            $sql .= " and contacts like '%$contacts%'";
        }

        if($status)
        {
            $sql .= " and status = '$status'";
        }


        $customList = Custom::whereRaw($sql)->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $data = array('title' => '点位管理','customList'=>$customList);
        $data['custom_name'] = $custom_name;
        $data['contacts'] = $contacts;
        $data['status'] = $status;

        return View::make('custom.index',$data);
    }

    public function edit()
    {
        $act = Request::segment(2)=='show'?true:false;
        $id = Input::get('id');
        $custom_name = Input::get('custom_name','');
        $attr = Input::get('attr','');
        $contacts = Input::get('contacts','');
        $mobile = Input::get('mobile','');
        $telephone = Input::get('telephone','');
        $email = Input::get('email','');
        $status = Input::get('status','');
        $place = Input::get('place','');
        $next_visit_time = Input::get('next_visit_time','');
        if(Request::getMethod()=='POST')
        {
            $data['custom_name'] = $custom_name;
            $data['attr']  = $attr;
            $data['contacts'] = $contacts;
            $data['place'] = $place;
            $data['mobile']  = $mobile;
            $data['telephone']  = $telephone;
            $data['email']  = $email;
            $data['status']  = $status;
            $data['next_visit_time'] = strtotime($next_visit_time);

            $custom = new Custom();
            if(!$custom->validate($data,$custom->getRules()))
            {
                $error = $custom->errors();
                return Redirect::to('/custom/edit')->with('user',Auth::user())->withErrors($error)->withInput();
            }


            $data['author_id'] = Auth::user()->id;
            $custom->fill($data);
            if($id)
            {
                $result = $custom->where('id','=',$id)->update($data);
            }
            else{
                $result = $custom->save();
            }

            if($result)
            {
                return Redirect::to('custom/index');
            }else{
                return Redirect::to('custom/edit')->with('flag',true);
            }

        }
        if($id)
        {
            $custom = Custom::find($id);
        }
        else
        {
            $custom = new Custom();
        }
        $data['custom_name'] = $custom->custom_name;
        $data['attr']  = $custom->attr;
        $data['contacts'] = $custom->contacts;
        $data['place'] = $custom->place;
        $data['mobile']  = $custom->mobile;
        $data['telephone']  = $custom->telephone;
        $data['email']  = $custom->email;
        $data['status']  = $custom->status;
        $data['next_visit_time'] = $custom->next_visit_time;
        $data['id']  = $id;
        $data['title']     = '添加客户信息';
        $data['act']       = $act;
        return View::make('custom.edit',$data);
    }


    public function del($ids)
    {
        $idArr = explode(',',$ids);
        $user = new Custom();
        foreach($idArr as $key => $val)
        {
            $user->where('id','=',$val)->delete();
        }
        echo 'success';
        exit();
    }

    public function record($id)
    {
        $recordList = CustomRecord::where('custom_id','=',$id)->orderBy('id','desc')->paginate($this->pageSize);
        $data = array
        (
            'title' => '客户访问记录',
            'recordList'  => $recordList,
        );
        return View::make('custom.index_record',$data);
    }

    public function editRecord()
    {
        $id = Input::get('id');
        if(!$id)
        {
            return Redirect::to('/custom/index');
        }
        $custom = Custom::find($id);
        $data = array(
            'title'   => '设置定期回访时间',
            'custom'  => $custom,
        );
        if(Request::getMethod()=='POST')
        {
            $arr['status'] = Input::get('status');
            $arr['next_visit_time'] =  strtotime(Input::get('next_visit_time'));
            Custom::where('id','=',$id)->update($arr);
            $arr2['custom_id'] = $id;
            $arr2['custom_status'] = Input::get('status');
            $arr2['remark']  = Input::get('remark');
            $arr2['next_visit_time'] = strtotime(Input::get('next_visit_time'));
            CustomRecord::create($arr2);
            return Redirect::to('/custom/index');
        }
        return View::make('custom.edit_record',$data);
    }

    /**
     * @todo 查看业务员销售状况
     * @author Justin.BJ@msn.com
     * @since $id
     * @return mixed
     *
     */
    public function checker()
    {
        //$menuList = Menu::with('author')->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $sql = '1=1';
        $sqlArr = array();
        $custom_name = Input::get('custom_name','');
        $saler = Input::get('saler','');
        $start_date = Input::get('start_date','');
        $end_date = Input::get('end_date','');
        if($custom_name)
        {
            $sql .= " and custom_name like ?";
            $sqlArr[] = '%'.$custom_name.'%';
        }

        if($saler)
        {
            $salerList = User::where('truename','like',"%$saler%")->lists('id');
            $sql .= " and author_id in (?)";
            $sqlArr[] = implode(',',$salerList);
        }

        if($start_date)
        {
            $sql .= " and next_visit_time > ? ";
            $sqlArr[] = strtotime($start_date);
        }

        if($end_date)
        {
            $sql .= " and next_visit_time < ?";
            $sqlArr[] = strtotime($end_date) + 24 * 3600;
        }
        $customList = Custom::whereRaw($sql,$sqlArr)->orderBy('created_at', 'desc')->paginate($this->pageSize);
        $data = array('title' => '销售管理','customList'=>$customList);
        $data['custom_name'] = $custom_name;
        $data['saler'] = $saler;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        return View::make('custom.checker',$data);

    }

}
