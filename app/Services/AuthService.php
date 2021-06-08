<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\ValidationException;


class AuthService
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /*
    * Obtiene el email y el password enviados por usuario
    * y envia el mensaje con la confirmación de email
    */
    public function sendValidateMail($request, $user)
    {
        $data = $request->only(['email', 'password']);
        $validator = Validator::make($data, [
            'email' => 'required|email:rfc',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $mensaje = $validator->errors()->first();
            throw ValidationException::withMessages(['status' => 400, 'errors' => $mensaje, 'data' => $data])->status(400);
        }

        if ($user->email_verified_at == null || $user->status == 1) {

            $data = [
                'url' => config('paramslist.verifyEmail') . '/' . $user->id . '?token=' . $user->temporalTocken . '&status=' . $user->status,
                'name' => $user->name,
                'email' => $user->email,
                'code' => $user->especialParam,
                'autoDelete' => str_replace('%id%', $user->id, config('paramslist.autoDelete')),
            ];

            try {
                // Actualiza el status del usuario
                $this->userRepository->changeStatus($user->id, config('paramslist.status.valCodEnviado'));
                MailService::sendVerifyMail($data);
                $result = ['success' => __('auth.send:email'), 'status' => 200];
                return $result;

            } catch (Exception $e) {
                $mensaje = $e->getMessage();
                $result = ['error' => $mensaje, 'status' => 400];
                return response()->json($result, $result['status']);
            }
        } else {
            return ['status' => 200];
        }
    }

    /**
     * Verifica el mensaje enviado al correo electrónico donde generando en el registro un
     * numero de 6 digitos y lo valida vs la bd en $user->especialParam el tocken se borra por cron 24 horas despues obligando
     * a generar un nuevo tocken y un nuevo codigo.
     */
    public function verifyValidateMail($id, $request, $user)
    {
        if ($user->temporalTocken == $request->tocken && $user->especialParam == $request->code) {
            $this->userRepository->verifyEmail($id);
            $this->userRepository->changeStatus($user->id, config('paramslist.status.valCodAceptado'));
            return ['status' => 200];
        } else if ($user->temporalTocken != $request->tocken && $user->especialParam != $request->code) {
            $this->userRepository->changeStatus($id, config('paramslist.status.valCodRechazado'));
            return ['status' => 400];
        }
    }

    /**
     *
     * Pendiente la creación del cron verifyValidateMail ED-65
     *
     */
    public function cronDeleteTocken(){

    }



    public function tockenGenerate($user)
    {
        $this->userRepository->changeStatus($user->id, config('paramslist.status.aceptado'));

        $findUser = $this->userRepository->getById($user->uuid);

        $user->tokens()->delete();
        $success['token'] =  $user->createToken($user->nickname, ['*']);
        return response()->json(['token' => $success['token']->plainTextToken, 'user' => $findUser], 200);
    }
}
