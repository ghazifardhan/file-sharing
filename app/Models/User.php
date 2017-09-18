<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $valid = [
        'name' => 'required|min:6',
        'email' => 'required|email',
        'password' => 'required|min:6'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $msg = [
        'name.required' => 'Required',
        'name.min' => 'Min 6 character',
        'email.required' => 'Required',
        'email.email' => 'Must be a valid email',
        'password.required' => 'Required',
        'password.min' => 'Min 6 character',
    ];

    public function message(){
        return $this->msg;
    }

    public function validate(){
        return $this->valid;
    }

    public function group(){
        return $this->hasOne('App\Models\Group', 'id', 'owner_id');
    }
}
