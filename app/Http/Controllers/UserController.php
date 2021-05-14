<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @var userService
     */
    protected $userService;

    /**
     * UserController Constructor
     *
     * @param UserService $userService
     *
     */
    public function __construct(UserService $userService)
    {
        $this->middleware(['permission:update:user'])->only(['update']);
        $this->middleware(['permission:restore:user'])->only(['restore']);
        $this->middleware(['permission:store:user'])->only(['store']);
        $this->middleware(['permission:collection:user'])->only(['index']);
        $this->middleware(['permission:find:user'])->only(['show']);
        $this->middleware(['permission:delete:user'])->only(['destroy']);
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $result = ['status' => 200, 'content' => $this->userService->getAll($request)];
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: UserController index';
            Log::error($mensaje);
            $result = ['error' => $mensaje, 'status' => 500];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['name', 'lastname', 'cardId', 'email', 'mobile',
         'displayName', 'nickname', 'about', 'password']);

        $result = ['status' => 200];
        try {
            $result['data'] = $this->userService->saveUserData($data);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: UserController store';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = ['status' => 200];
        try {
            HelperController::validateUuid($id);
            return $this->userService->getById($id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: UserController show';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Update user.
     *
     * @param Request $request
     * @param id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'lastname', 'cardId', 'email', 'mobile', 'nickname', 'about', 'language', 'town', 'status']);

        $result = ['status' => 200];
        try {
            $result['data'] = $this->userService->updateUser($data, $id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: UserController update';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $request->only(['deleteForever']);
        $result = ['status' => 200];
        try {
            $result['data'] = $this->userService->deleteById($data, $id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: UserController destroy';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id)
    {
        $result = ['status' => 200];
        try {
            $result['data'] = $this->userService->restoreById($id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: UserController restore';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
    }
}
