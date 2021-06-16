<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use App\Services\LocationService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthService;


class AuthController extends Controller
{
    /**
     * UserController Constructor
     *
     * @param UserService $userService
     *
     */
    public function __construct(UserService $userService, LocationService $location, AuthService $authService)
    {
        $this->location = $location;
        $this->userService = $userService;
        $this->authService = $authService;
    }


    public function login(Request $request)
    {
        $result = ['status' => 200];
        //****************************** modificar
        $user = User::where('email', $request->email)->first();
        // Se demarca el idioma de la función
        $this->location->validationLocale($user->language, null);

        $result = $this->authService->sendValidateMail($request, $user);

        if ($result['status'] == 200) {
            if (!$user || !Hash::check($request->password, $user->password)) {
                $mensaje = __('auth.failed');
                $result = ['error' => $mensaje, 'status' => 401];
                return response()->json($result, $result['status']);
            } else {
                if ($user->email_verified_at != null) {
                    return $this->authService->tockenGenerate($user);
                } else {
                    return response()->json($result, $result['status']);
                }
            }
        } else {
            $mensaje = __('auth.email:validation') . $request->email;
            Log::error($mensaje);
            return response()->json($result, $result['status']);
        }
    }

    public function verifyMailShow($id, Request $request)
    {
        try {
            $result = ['status' => 200, 'content' => $this->userService->getFind($id, $request)];
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: UserController VerifyEmail';
            Log::error($mensaje);
            $result = ['error' => $mensaje, 'status' => 500];
        }
        return response()->json($result, $result['status']);
    }

    public function verifyMail($id, Request $request)
    {

        $user = $this->userService->getFind($id, $request);
        $this->authService->verifyValidateMail($id, $request, $user);

        try {
            $result = ['status' => 200, 'content' => $this->userService->getFind($id, $request)];
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: UserController VerifyEmail';
            Log::error($mensaje);
            $result = ['error' => $mensaje, 'status' => 500];
        }
        return response()->json($result, $result['status']);
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
