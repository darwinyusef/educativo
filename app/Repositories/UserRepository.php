<?php

namespace App\Repositories;

use App\Models\User;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $user;
    protected $paginate = 10;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->paginate = 10;
    }

    /**
     * Get all users.
     *
     * @return User $user
     */
    public function getAll($request)
    {
        if ($request->paginate) {
            $this->paginate = $request->paginate;
        }

        return new UserCollection(
            $this->user
                ->card($request->card)
                ->name($request->name)
                ->paginate($this->paginate)
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
       $find = $this->user->uuid($id)->select('id', 'uuid')->get();
       return $this->user->find($find[0]->id);
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

        $user->uuid = Str::uuid();
        $user->name = $data['name'];
        $user->lastname = $data['lastname'];
        $user->cardId = $data['cardId'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        $user->password = Hash::make($data['password']);
        $user->displayName = $data['name'] . ' ' . $data['lastname'];
        $user->slug = Str::slug($data['name'] . ' ' . $data['lastname']);
        $user->nicname = $data['nicname'];
        $user->about = $data['about'];
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
        $user->name = $data['name'];
        $user->lastname = $data['lastname'];
        $user->cardId = $data['cardId'];
        $user->email = $data['email'];
        $user->mobile = $data['mobile'];
        $user->displayName = $data['name'] . ' ' . $data['lastname'];
        $user->slug = Str::slug($data['name'] . ' ' . $data['lastname']);
        $user->nicname = $data['nicname'];
        $user->about = $data['about'];
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


    /**
     * Update User
     *
     * @param $data
     * @return User
     */
    public function totalDelete($id)
    {
        $user = $this->user->find($id);
        $user->forceDelete();
        return $user;
    }

    /**
     * Update User
     *
     * @param $data
     * @return User
     */
    public function restoreDelete($id)
    {
        $user = $this->user->find($id);
        $user->restore();
        return $user;
    }
}
