<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function user(){
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }
}
