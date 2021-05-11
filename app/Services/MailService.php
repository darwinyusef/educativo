<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelperController;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyMail;
use Carbon\Carbon;

use Exception;
use InvalidArgumentException;

class MailService
{

    public static function sendVerifyMail($data)
    {
        try {
            Mail::to($data['email'])->locale('es')->send(new VerifyMail($data));
        } catch (Exception $e) {
            throw new InvalidArgumentException($e . '[Error]: Enviar email');
        }
    }
}
