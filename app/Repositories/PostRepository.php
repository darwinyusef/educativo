<?php

namespace App\Repositories;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PostRepository
{
    protected $post;
    protected $paginate = 10;

    /**
     * PostRepository constructor.
     *
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->paginate = 10;
        $this->context = '';
        $this->title = '';
    }

    /**
     * Get all posts.
     *
     * @return Post $post
     */
    public function getAll($request, $context)
    {
        if ($request->paginate) {
            $this->paginate = $request->paginate;
        }

        if ($context) {
            $this->context = $context;
        }

        if ($request->title) {
            $this->title = $request->title;
        }

        return new PostCollection( $this->post
                                    ->paginate($this->paginate)
                                    ->context($this->context)
                                    ->title($this->title)
                                    );
    }

    /**
     * Get post by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $find = $this->post->uuid($id)->select('id', 'uuid')->get();
        return new PostResource($this->post->find($find[0]->id));
    }

    /**
     * Save Post
     *
     * @param $data
     * @return Post
     */
    public function save($data)
    {
        $post = new $this->post;
        $post->uuid = Str::uuid();
        $post->name = $data['name'];


        $post->save();
        return $post->fresh();
    }

    /**
     * Update Post
     *
     * @param $data
     * @return Post
     */
    public function update($data, $id)
    {
        $post = $this->post->find($id);
        $post->name = $data['name'];
        $post->update();
        return $post;
    }

    /**
     * Update Post
     *
     * @param $data
     * @return Post
     */
    public function delete($id)
    {
        $post = $this->post->find($id);
        $post->delete();
        return $post;
    }


    /**
     * Update Post
     *
     * @param $data
     * @return Post
     */
    public function totalDelete($id)
    {
        $post = $this->post->find($id);
        $post->forceDelete();
        return $post;
    }


    /**
     * Get post by id
     *
     * @param $id
     * @return mixed
     */
    public function getByIdWithTrashed($id)
    {
        $find = $this->post->withTrashed()->uuid($id)->select('id', 'uuid')->get();
        return $this->post->withTrashed()->find($find[0]->id);
    }

    /**
     * Update Post
     *
     * @param $data
     * @return Post
     */
    public function restore($id)
    {
        $post = $this->post->withTrashed()->find($id);
        $post->restore();
        return $post;
    }
}
