<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * UserController Constructor
     *
     * @param UserService $userService
     *
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        //$listo = User::find('65465-6546-4654')->update(['password'=> bcrypt(123456)]);
    }

    public function login()
    {

        $user = User::where('email', 'wsgestor@gmail.com')->first();


        // if ($user) {
        //  $success['token'] =  $user->createToken('yusefP2', ['*', 'user:create', 'user:active']);

        //     return ['token' => $success['token']->plainTextToken];
        //     return response()->json(['success' => $success]);
        // } else {
        //     return response()->json(['error' => 'Unauthorised'], 401);
        // }
        $user->assignRole('admin');
    }


    public function register(Request $request)
    {

        $data = $request->only(['email', 'nickname', 'status', 'password']);

        try {
            $result = ['status' => 200, 'content' => $this->userService->registerUserData($data)];
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: UserController index';
            Log::error($mensaje);
            $result = ['error' => $mensaje, 'status' => 500];
        }
        return response()->json($result, $result['status']);
    }
}
