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

    public function create(Request $request){
        
        $file = $request->file('media');
        //var_dump($file);
        $res['file_name'] = $file->getClientOriginalName();
        $res['mime_type'] = $file->getMimeType();
        $res['size'] = $file->getSize();

        return $res;

        /*
        $disk = Storage::disk(config('filesystems.default'));
        $user = JWTAuth::parseToken()->authenticate();
        //Check the input data valid or not
        $error = array();
       //Handle media file
       if ($request->hasFile('media')) {
                         $file = $request->file('media');
                         //$path = $file->store('productmedia/'.$rand);
                         $link = $disk->put($request->input('product_id'), $file, 'public');
                         //return $link;
                         $url = $disk->url($link);
                         
       }
           $size = $file->getSize();
           $this->upload_media->fill([
                     'product_id' => $request->input('product_id'),
                     'title' => $request->input('title'),
                     'media_type' => $file->getMimeType(),
                     'main_position' => $request->input('main_position'),
                     'status' => $request->input('status'),
                     'file_path' => $url, //Save to storage
                     'file_size' => $size,
                     'file_location' => 'google',
                   ]);
           if ($this->upload_media->save()) {
               $res['success'] = true;
               $res['result'] = 'Success add upload_media!';

               return response($res);
           }
        else {
           $error = $valid->errors();
           $res['success'] = false;
           $res['result'] = 'Inserted data not complete';
           $res['message'] = $error;

           return response($res);
       }
       */

    }
}
