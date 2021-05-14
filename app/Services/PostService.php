<?php

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelperController;

use App\Services\SeoService;
use Carbon\Carbon;

use Exception;
use InvalidArgumentException;

class PostService
{
    /**
     * @var $postRepository
     */
    protected $postRepository;
    protected $seoService;

    /**
     * PostService constructor.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository, SeoService $seo)
    {
        $this->seoService = $seo;
        $this->postRepository = $postRepository;
    }

    /**
     * Get all post.
     *
     * @return String
     */
    public function getAll($request)
    {
        if ($this->valContextArray($request->context) == 1) {
            $context = $request->context;
        }

        return $this->postRepository->getAll($request, $context);
    }

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        HelperController::validateUuid($id);
        return $this->postRepository->getById($id);
    }

    public function valContextArray($context)
    {
        $array = ['attachment', 'page', 'post', 'revision', 'portfolio', 'directory', 'publicity', 'course', 'homework', 'reading', 'leader', 'poadcast', 'video'];
        if (in_array($context, $array)) {
            return 1;
        } else {
            abort(404);
            return 0;
        }
    }

    private function validate($data)
    {
        return Validator::make($data, [
            'name' => 'required|string',
        ]);
    }

    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updatePost($data, $id)
    {
        $validator = $this->validate($data);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            HelperController::validateUuid($id);
            $findPost = $this->postRepository->getById($id);
            $post = $this->postRepository->update($data, $findPost->id);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('No se a actualizado la data');
        }
        DB::commit();
        return $post;
    }

    /**
     * Validate post data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function savePostData($data)
    {
        $data['created_at'] = Carbon::parse($data['created_at']);
        $data['time_in'] = Carbon::parse($data['time_in']);
        $data['time_out'] = Carbon::parse($data['time_out']);
        if ($data['type_list'] == 'draft') {
            $data['password'] = $data['password'];
        } else {
            $data['password'] = null;
        }
        /**
         * todos los meta tags estan documentados de manera exigente en la siguiente url
         * https://desarrolloweb.com/articulos/meta-tags-redes-sociales-html.html
         */

        $data['json'] = $this->seoService->json($data);
        $data['meta'] = $this->seoService->metaTag($data);


        $validator = $this->validate($data);
        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
        $result = $this->postRepository->save($data);
        return $result;
    }


    /**
     * Delete post by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($data, $id)
    {
        DB::beginTransaction();
        try {
            HelperController::validateUuid($id);
            $findPost = $this->postRepository->getById($id);
            if ($data == []) {
                $data['deleteForever'] = 'no';
                $post = $this->postRepository->delete($findPost->id);
            }

            if ($data['deleteForever'] == 'si') {
                $post = $this->postRepository->totalDelete($findPost->id);
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException($e . 'Al borrar el post');
        }
        DB::commit();
        return $post;
    }

    /**
     * Restore post by id.
     *
     * @param $id
     * @return String
     */
    public function restoreById($id)
    {
        DB::beginTransaction();
        try {
            HelperController::validateUuid($id);
            $findPost = $this->postRepository->getByIdWithTrashed($id);
            $post = $this->postRepository->restore($findPost->id);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('Al restaurar el post');
        }
        DB::commit();
        return $post;
    }


    /**
     * Validate post data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function registerPostData($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|unique:posts|email',
            'nickname' => 'required',
            'password' => 'required|string|min:6',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->postRepository->register($data);

        return $result;
    }
}
