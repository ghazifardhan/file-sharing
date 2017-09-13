<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use JWTAuth;
use Auth;


class AuthController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function login(Request $request){
        
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                  'data' => [
                    'success' => false,
                    'result' => 'Email atau Password anda salah']
                  ], 200);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }
        
		$user = Auth::User();

        $data = array(
            'success' => true,
            'token' => $token,
            'email' => $user->email,
            'name'  => $user->name,
            'result' => 'Logged In'
        );

        return response()->json(compact('data'));
    }
}
