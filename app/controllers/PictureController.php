<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 14-9-15
 * Time: 22:38
 */

class PictureController extends BaseController {
    public function getIndex()
    {
        $data['title'] = "图库";
        $pictureList = PictureStorage::orderBy('created_at', 'desc')->paginate($this->picturePageSize);
        $data['pictureList'] = $pictureList;
        return View::make('picture.index',$data);
    }

    public function getAdd()
    {
        $data['title'] = "上传图片";
        return View::make('picture.add',$data);
    }

    public function postUpload()
    {
        $author_id = Auth::user()->id;
        if(Request::getMethod()=='POST')
        {
            $file = Input::file('image_path');
            $filePath = [];
            foreach($file as $key => $val)
            {
                if($val->isValid())
                {
                    $tmp = [];
                    $ext = $val->guessClientExtension();
                    $filename = $val->getClientOriginalName();
                    $dir_path = date('Ymd');
                    $val->move(public_path().'/data/'.$dir_path, md5(date('YmdHis').$filename).'.'.$ext);
                    $image_path = '/data/'.$dir_path.'/'.md5(date('YmdHis').$filename).'.'.$ext;
                    $tmp['image_path'] = $image_path;
                    $tmp['author_id'] = $author_id;
                    $tmp['origin_name'] = $filename;
                    array_push($filePath,$tmp);
                }
                else
                {
                    continue;
                }
            }
            if(count($filePath))
            {
                $rs = PictureStorage::insert($filePath);
            }
            return Redirect::action('PictureController@getIndex');
        }
        else
        {
            return Redirect::action('PictureController@getAdd');
        }
    }
} 