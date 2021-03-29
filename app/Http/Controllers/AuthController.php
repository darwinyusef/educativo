<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function index(){
        User::find('65465-6546-4654')->update(['password'=> bcrypt(123456)]);
        dd ( 1 );
    }

    public function creadito(){

        $user = User::where('email' , 'wsgestor@gmail.com')->first();

        if($user){
            $success['token'] =  $user->createToken('yusefPruebita', ['*', 'user:create', 'user:active']);
            return response()->json(['success' => $success]);
        }else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }

    }


    public function login(){
        return 1;
    }
}
