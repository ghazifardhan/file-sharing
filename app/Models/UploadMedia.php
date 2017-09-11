<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadMedia extends Model
{
    protected $table = 'upload_media';

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
