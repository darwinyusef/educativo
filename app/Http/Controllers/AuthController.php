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


    public function verifyMail($make, $message)
    {
        $token = User::find($make->id)->remember_token;
        $data = [
            'email' => $make->email,
            'user' => $make->id,
            'verify_token' => $token,
            'name' => $make->name,
            'type' => $message['type'],
            'url' => $message['url'],
            'action' => $message['action'],
            'btntext' => $message['btntext']
        ];
    }


    public function acceptedEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $data = 0;
        if ($user->getRememberToken() == $request->input('token')) {
            $users = User::findOrFail($request->input('live'))->update([
                'status' => 1,
                'remember_token' => null
            ]);
        }

        if ($request->input('type') == 'manual') {
            return redirect('/backend/home');
        } else if ($request->input('type') == 'influencers') {
            $this->contentMail($request, $user);
            return redirect($request->input('url'));
        } else if ($request->input('type') == 'lead_magnet') {
            $this->contentMail($request, $user);
            return redirect($request->input('url'));
        } else {
            return redirect($request->input('url'));
        }
    }


    public function exist($request)
    {
        $validateUser = User::where('email', $request->email)->first();
        $make = $request->all();

        if ($validateUser) {
            // Activa el usuario si se encuentra en bd y si no se a validado aun el email
            if ($validateUser->remember_token != null) {
                $user = $validateUser;
                $message = [
                    "type" => $make['type'],
                    "url" => $make['url'],
                    "action" => $make['action'],
                    "btntext" => $make['btntext'],
                    "image" => $make['image'],
                ];

                $verify = $this->verifyMail($user, $message);
                if ($verify == 0) {
                    $users = User::findOrFail($user->id)->update([
                        'status' => 1,
                    ]);
                }
            }
        } else {
            //crea un usuario nuevo y lo envia a validación
            $make = $request->all();
            if (isset($make->name)) {
                $name = $make['first'] . ' ' . $make['last'];
            } else {
                $name = $make['name'];
            }

            $make = Arr::add($make, 'slug', $slug);
            $make = Arr::add($make, 'display_name', $name);
            $make = Arr::add($make, 'status', 0);
            $make = Arr::add($make, 'remember_token', str_random(40));
            $make['password'] = bcrypt($make['password']);
            // se carga la solicitud
            $user = User::create($make);
            $user->assignRole('user');
            if ($make['type'] == 'manual' || $make['type'] == 'none') {
                $verify = $this->verifyMailManual($user);
            } else {
                $message = [
                    "type" => $make['type'],
                    "url" => $make['url'],
                    "action" => $make['action'],
                    "btntext" => $make['btntext'],
                    "image" => $make['image'],
                ];
                if ($make['type'] == 'lead_magnet' || $make['type'] == 'influencers') {
                    $message['add'] = $make['add'];
                    $message['product'] = $make['product'];
                }
                $verify = $this->verifyMail($user, $message);
                if ($verify == 0) {
                    $users = User::findOrFail($user->id)->update([
                        'status' => 1,
                    ]);
                }

            }
            //
            return [$make['url'],  $make['type']];
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

        if (!$user || !Hash::check($request->password, $user->password)) {
            $mensaje = 'Las credenciales son incorrectas.';
            throw ValidationException::withMessages(['email' => $mensaje]);
            $result = ['status' => 500, 'error' => $mensaje];
        }


        //return $user->createToken($request->device_name)->plainTextToken;

        $data = [
            'url' => config('paramslist.verifyEmail').$user->id,
            'name' => $user->name,
            'email' => $user->email,
            'autoDelete' => config('paramslist.autoDelete').$user->id,
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

    public function mail(){
        return view('mails.theme');
    }
}
