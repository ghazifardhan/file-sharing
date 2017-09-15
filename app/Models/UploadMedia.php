<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadMedia extends Model
{
    protected $table = 'upload_media';

    protected $fillable = [
        'group_id', 'user_id', 'media_name', 'media_type', 'file_path', 'file_location', 'flag'
    ];

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
