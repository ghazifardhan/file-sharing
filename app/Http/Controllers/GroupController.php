<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\UserGroup;
use JWTAuth;
use Validator;

class GroupController extends Controller
{
    var $group;

    public function __construct(){
        $this->group = new Group();
    }

    public function index(){
        $user = JWTAuth::parseToken()->authenticate();

        $group = $this->group->where('owner_id', $user->id)->get();

        $res['data'] = $group;

        return response($res);
    }

    public function create(Request $request){

        $user = JWTAuth::parseToken()->authenticate();
        $valid = $this->_validate($request->input());
        
        if($valid->passes() === TRUE){
            $group = $this->group->fill([
                'group_name' => $request->input('group_name'),
                'description' => $request->input('description'),
                'owner_id' => $user->id
            ]);
            if($group->save()){

                $usergroup = new UserGroup();
                $usergroup->fill([
                    'group_id' => $group->id,
                    'user_id' => $user->id,
                    'role_id' => 1
                ]);
                $usergroup->save();

                $res['success'] = true;
                $res['result'] = 'Success create group';
            } else {
                $res['success'] = false;
                $res['result'] = 'Failed create group';
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
         $validators = $this->group->validate();
         $messages = $this->group->message();
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
