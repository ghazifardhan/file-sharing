<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{   

    protected $table = 'groups';

    protected $fillable = [
        'group_name', 'description', 'owner_id'
    ];

    protected $validate = [
      'group_name' => 'required', 
      'description' => 'required',
    ];

    protected $message = [
        'group_name.required' => 'Required',
        'description.required' => 'Required'
    ];

    public function message(){
        return $this->message;
    }

    public function validate(){
        return $this->validate;
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }
}
