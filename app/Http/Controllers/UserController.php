<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserController extends Controller
{   

    var $user;

    public function __construct(){
        $this->user = new User();
    }

    public function create(Request $request){

        $valid = $this->_validate($request->input());

        if($valid->passes() === TRUE){
            $user = $this->user->fill([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);
            if($user->save()){
                $res['success'] = true;
                $res['result'] = 'Success register account';
            } else {
                $res['success'] = false;
                $res['result'] = 'Failed register account';
            }
        } else {
            $res['success'] = false;
            $res['result'] = $valid->errors();
        }

        return response($res);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     private function _validate($data, $fields = array())
     {
         $validators = $this->user->validate();
         $messages = $this->user->message();
         if (!empty($fields)) {
             foreach ($fields as $field) {
                 $validator[$field] = $validators[$field];
             }
         } else {
             $validator = $validators;
         }
         $invalid = Validator::make($data, $validator, $messages);

         return $invalid;
     }
}
