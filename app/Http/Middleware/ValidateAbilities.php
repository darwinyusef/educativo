<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use InvalidArgumentException;

class ValidateAbilities
{
    public function handle($request, Closure $next, $into)
    {
        if(boolval( $into )) {
            return $next($request);
        }else{
            $result = ['error' => 'Actualmente no cuenta con permisos para acceder a este espacio', 'status' => 403];
            return response()->json($result, 403);
        }

    }
}
