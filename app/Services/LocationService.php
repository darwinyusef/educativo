<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\HelperController;
use Exception;
use Illuminate\Validation\ValidationException;


class LocationService
{

    public function domainLocale($domain)
    {
        App::setLocale($domain);
    }

    public function userLocale($user)
    {
        App::setLocale($user);
    }

    public function validationLocale($user, $domain){

        if($user == null && $domain != null){
            if( in_array($domain, config('paramslist.languages')) ){
                return $this->domainLocale($domain);
            } else {
                abort(404);
            }
        } else if($user != null && $domain == null){
            if( in_array($user, config('paramslist.languages')) ){
                return $this->userLocale($user);
            } else {
                abort(404);
            }
        }else if($user == null && $domain == null){
            App::setLocale(config('paramslist.languages:principal'));
        } else if($user != null && $domain != null){
            App::setLocale(config('paramslist.languages:principal'));
        }
    }

}
