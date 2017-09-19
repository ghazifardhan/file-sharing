<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use Illuminate\Http\File;
use Storage;

use App\Models\UploadMedia;

class UploadMediaController extends Controller
{
    var $upload_media;

    public function __construct(){
        $this->upload_media = new UploadMedia();
    }

    public function index(Request $request){
	
	$user = JWTAuth::parseToken()->authenticate();
	$file = $this->upload_media->where('user_id', $user->id)->get();
	
	$res['data'] = $file;
	return response($res);
    }

    public function create(Request $request){
        
        $disk = Storage::disk(config('filesystems.default'));
        $user = JWTAuth::parseToken()->authenticate();
        //Check the input data valid or not
        $error = array();
        //Handle media file
        //if ($request->hasFile('media')) {
        $file = $request->file('media');
        $my_file = $_FILES['media'];
        //$path = $file->store('productmedia/'.$rand);
        $link = $disk->put("my_media/".$user->id, $file, 'public');
        //return $link;
        $url = $disk->url($link);

        if($request->input('group_id') != NULL){
            $group_id = $request->input('group_id');
            $flag = 1;
        } else {
            $group_id = NULL;
            $flag = 0;
        }
        
        $this->upload_media->fill([
                    'group_id' => $group_id,
                    'user_id' => $user->id,
                    'media_name' => $my_file['name'],
                    'media_type' => $my_file['type'],
                    'file_path' => $url, //Save to storage
                    'file_location' => 'google',
                    'file_size' => $my_file['size'],
                    'flag' => $flag
                ]);
        if ($this->upload_media->save()) {
            $res['success'] = true;
            $res['result'] = 'Success add upload_media!';
            $res['file'] = $file;
            $res['upload_limit'] = ini_get('post_max_size');

            return response($res);
        }
        else {
           $error = $valid->errors();
           $res['success'] = false;
           $res['result'] = 'Inserted data not complete';
           $res['message'] = $error;

           return response($res);
       }

    }
}
