<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function group(){
        return $this->hasOne('App\Models\Group', 'id', 'owner_id');
    }
}
