<?php

class HomeController extends BaseController {

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

	public function showWelcome()
	{
        //$this->layout->content = View::make('home.index');
        $range = isset(Auth::user()->grade->range)?Auth::user()->grade->range:'';
        $grade = isset(Auth::user()->grade->grade_name)?Auth::user()->grade->grade_name:'';
        $messageList = [];
        if($range=="1")
        {
            $messageList = Message::where('m_type','=','1')->orderBy('created_at','desc')->limit('10')->get();
        }
        elseif($grade)
        {
            $messageList = Message::where('m_type','=','1')->where('recevier','like','%'.$grade.'%')->orderBy('creaded_at',desc)->limit('10')->get();
        }

        $tashList = [];
        if($range=="1")
        {
            $tashList = Message::where('m_type','=','2')->orderBy('created_at','desc')->limit('10')->get();
        }
        elseif($grade)
        {
            $tashList = Message::where('m_type','=','2')->where('recevier','like','%'.$grade.'%')->orderBy('creaded_at',desc)->limit('10')->get();
        }
        $data = array(
            'title'       => '控制中心',
            'messageList' => $messageList,
            'taskList'    => $tashList,
        );
		return View::make('home.index',$data);
	}

}
