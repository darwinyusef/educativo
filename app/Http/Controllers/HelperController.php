<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ErrorException;

class HelperController extends Controller
{
    static public function validateUuid($uuid){
        if( !preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uuid) ){
            throw new ErrorException('No es posible encontrar el elemento pues no es un id de tipo UUID');
        }
    }
}
