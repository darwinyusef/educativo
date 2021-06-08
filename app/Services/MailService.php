<?php

namespace App\Services;

use App\Http\Controllers\HelperController;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Arr;

use Exception;
use InvalidArgumentException;

class MailService
{

    public static function sendVerifyMail($data)
    {
        $data = Arr::add($data, 'tratamiento', config('paramslist.tratamiento'));

        try {
            Mail::to($data['email'])->locale('es')->send(new VerifyMail($data));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e . '[Error]: Enviar email');
        }
    }
}
