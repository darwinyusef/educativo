<?php

namespace App\Repositories;

use App\Models\User;
use App\Http\Resources\UserCollection;

class UserRepository
{
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get all users.
     *
     * @return User $user
     */
    public function getAll($request)
    {
        $paginate = 10;
        if ($request->paginate) {
            $paginate = $request->paginate;
        }
        return new UserCollection( $this->user
                                        ->lastname($request->lastname)
                                        ->paginate($paginate)
                                 );
    }

    /**
     * Get user by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->user->find($id);
    }

    /**
     * Save User
     *
     * @param $data
     * @return User
     */
    public function save($data)
    {
        $user = new $this->user;

        $user->title = $data['title'];
        $user->description = $data['description'];
        $user->save();

        return $user->fresh();
    }

    /**
     * Update User
     *
     * @param $data
     * @return User
     */
    public function update($data, $id)
    {
        $user = $this->user->find($id);
        $user->title = $data['title'];
        $user->description = $data['description'];
        $user->update();
        return $user;
    }

    /**
     * Update User
     *
     * @param $data
     * @return User
     */
    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->delete();
        return $user;
    }
}
