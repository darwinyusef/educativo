<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MultimediaService;
use App\Services\PermissionsService;
use Exception;
use Illuminate\Support\Facades\Log;

class MultimediaController extends Controller
{
    private $multimediaService;
    private $authService;

    public function __construct(MultimediaService $multimediaService, PermissionsService $acPermission)
    {
        $this->multimediaService = $multimediaService;
        $this->middleware([ $acPermission->validatePermission('find:files') ])->only(['show']);
        $this->middleware([ $acPermission->validatePermission('collection:files') ])->only(['index']);
        $this->middleware([ $acPermission->validatePermission('create:files') ])->only(['store']);
        $this->middleware([ $acPermission->validatePermission('store:files') ])->only(['cargando']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $result = ['status' => 200, 'content' => $this->multimediaService->getAll($request)];
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: PostController index';
            Log::error($mensaje);
            $result = ['error' => $mensaje, 'status' => 500];
        }
        return response()->json($result, $result['status']);
    }


    public function show($id)
    {
        $result = ['status' => 200];
        try {
            HelperController::validateUuid($id);
            return $this->multimediaService->getById($id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: Multimedia Controller show';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
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


    public function update(Request $request, $id)
    {
    }


    public function destroy($id, Request $request)
    {
        $data = $request->only(['deleteForever']);
        $result = ['status' => 200];
        try {
            $result['data'] = $this->multimediaService->deleteById($data, $id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: Multimedia Controller destroy';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
    }
}
