<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;
use Exception;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * PostController Constructor
     *
     * @param PostService $postService
     *
     */
    public function __construct(PostService $postService)
    {
        $this->middleware(['permission:update:post'])->only(['update']);
        $this->middleware(['permission:restore:post'])->only(['restore']);
        $this->middleware(['permission:store:post'])->only(['store']);
        $this->middleware(['permission:collection:post'])->only(['index']);
        $this->middleware(['permission:find:post'])->only(['show']);
        $this->middleware(['permission:delete:post'])->only(['destroy']);
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $result = ['status' => 200, 'content' => $this->postService->getAll($request)];
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: PostController index';
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
        $listOnly = [
            'excerpt', 'title',  'content', 'password',
            'url', 'context', 'state', 'time_in', 'time_out', 'parent', 'notification',
            'html', 'status', 'language', 'user_id'
        ];

        $data = $request->only($listOnly);

        $result = ['status' => 200];
        try {
            $result['data'] = $this->postService->savePostData($data);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: PostController store';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = ['status' => 200];
        try {
            HelperController::validateUuid($id);
            return $this->postService->getById($id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: PostController show';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'excerpt', 'title',  'content', 'password',
            'url', 'context', 'state', 'time_in', 'time_out', 'parent', 'notification',
            'meta', 'json', 'html', 'status', 'language', 'user_id'
        ]);

        $result = ['status' => 200];
        try {
            $result['data'] = $this->postService->updatePost($data, $id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: PostController update';
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
            $result['data'] = $this->postService->deleteById($data, $id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: PostController destroy';
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
            $result['data'] = $this->postService->restoreById($id);
        } catch (Exception $e) {
            $mensaje = $e->getMessage() . ' [Error]: PostController restore';
            Log::error($mensaje);
            $result = ['status' => 500, 'error' => $mensaje];
        }
        return response()->json($result, $result['status']);
    }
}
