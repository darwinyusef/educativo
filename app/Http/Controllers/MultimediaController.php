<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MultimediaService;
use Exception;
use Illuminate\Support\Facades\Log;

class MultimediaController extends Controller
{
    private $multimediaService;

    public function __construct(MultimediaService $multimediaService)
    {
        $this->multimediaService = $multimediaService;
    }

    public function cargando(Request $request)
    {
        $diskList = $this->multimediaService->selectTypeFiles();
        $input_name = 'all_files';

        try {
            $data = $this->multimediaService->chargueFile($input_name, $request, $diskList);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: Chargue File store';
            Log::error($mensaje);
        }

       return  $this->store($request, $data);
    }

    private function store($request, $finalName)
    {
        $result = ['status' => 200];
        try {
            $result['data'] = $this->multimediaService->chargueFileBD($request, $finalName);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: MultimediaController store';
            Log::error($mensaje);
            $result = ['status' => 400, 'error' => $mensaje];
        }

        return response()->json($result, $result['status']);
    }

}
