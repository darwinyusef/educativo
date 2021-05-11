<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

// Se ejecuta el servicio de emails
use App\Services\MailService;

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


    public function verifyMail($make, $message)
    {
        $token = User::find($make->id)->remember_token;
        $data = [
            'email' => $make->email,
            'user' => $make->id,
            'remember_token' => $token,
            'name' => $make->name,
            'type' => $message['type'],
            'url' => $message['url'],
            'action' => $message['action'],
            'btntext' => $message['btntext'],
            'image' => $message['image'],
        ];

        if ($message['type'] == 'lead_magnet' || $message['type'] == 'influencers') {
            $data = Arr::add($data, 'add', $message['add']);
            $data = Arr::add($data, 'product', $message['product']);
        } else {
            $data = Arr::add($data, 'add', null);
            $data = Arr::add($data, 'product', null);
        }


    }

    public function create(Request $request)
    {
        $result = ['status' => 200];
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            $mensaje = 'Las credenciales son incorrectas.';
            throw ValidationException::withMessages([ 'email' => $mensaje ]);
            $result = ['status' => 500, 'error' => $mensaje];
            return response()->json($result, $result['status']);
        }


        return $user->createToken($request->device_name)->plainTextToken;

        $data = [
            'info' => 'El contenido de este es:',
            'fullname' => $user->name.' '.$user->lastname,
            'email' => 'desyugo@hotmail.com'
        ];

        try {
            MailService::sendVerifyMail($data);
        } catch (Exception $e) {
            $mensaje = $e->getMessage();
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);


        // if ($user) {
        //  $success['token'] =  $user->createToken('yusefP2', ['*', 'user:create', 'user:active']);

        //     return ['token' => $success['token']->plainTextToken];
        //     return response()->json(['success' => $success]);
        // } else {
        //     return response()->json(['error' => 'Unauthorised'], 401);
        // }
        //$user->assignRole('admin');
    }


    public function registerStore(Request $request)
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
