<?php

namespace App\Repositories;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserRepository
{
    protected $user;
    protected $paginate;

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
     * Get all users + Filters.
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
        return new UserResource($this->user->find($find[0]->id));
    }


    /**
     * Get user by id + filters
     *
     * @param $id
     * @return mixed
     */
    public function getByIdFilters($id, $request)
    {
        $find = $this->user->find($id);
        if($request->email != null){
            $find = $this->user->where('email', $request->email)->get();
            return $this->user->find($find[0]->id);
        }
        return $find;
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
        $user->nickname = $data['nickname'];
        $user->about = $data['about'];
        $user->especialParam = random_int(999999, 999999);
        $user->status = null;
        $user->temporalTocken = Str::slug(rand(10000000, 999999999), "");
        $user->save();

        $user->assignRole('user');
        return $user->fresh();
    }


    /**
     * Register User
     *
     * @param $data
     * @return User
     */
    public function register($data)
    {
        $user = new $this->user;

        $user->uuid = Str::uuid();
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->nickname = $data['nickname'];
        $user->especialParam = random_int(999999, 999999);
        $user->status = config('paramslist.status.inactivo');
        $user->temporalTocken = Str::slug(rand(10000000, 999999999), "");
        $user->save();

        // servicio de autenticación

        $rol = null;
        if ('user' == $data['status']) {
            $user->assignRole('user');
            $rol = 'user';
        }

        if ('student' == $data['status']) {
            $user->assignRole('student');
            $rol = 'student';
        }

        if ('teacher' == $data['status']) {
            $user->assignRole('teacher');
            $rol = 'teacher';
        }

        if ('contributor' == $data['status']) {
            $user->assignRole('contributor');
            $rol = 'contributor';
        }

        if ('author' == $data['status']) {
            $user->assignRole('author');
            $rol = 'author';
        }

        // servicio de autenticación
        if ($user->fresh()) {
            $success['token'] =  $user->createToken($data['nickname'], [$rol]);
            return [$user->fresh(), 200];
        } else {
            return [null, 401];
        }
    }


    /**
     * Update User
     *
     * @param $data
     * @return User
     */
    public function verifyEmail($id)
    {
        $user = $this->user->find($id);
        $user->temporalTocken = null;
        $user->especialParam = null;
        $user->status = 5;
        $user->email_verified_at = Carbon::now();

        $user->update();

        return new UserResource($user);
    }

        /**
     * Update User
     *
     * @param $data
     * @return User
     */
    public function changeStatus($id, $status)
    {
        $user = $this->user->find($id);
        $user->status = $status;
        $user->update();

        return $user;
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
        $user->nickname = $data['nickname'];
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
     * Get user by id
     *
     * @param $id
     * @return mixed
     */
    public function getByIdWithTrashed($id)
    {
        $find = $this->user->withTrashed()->uuid($id)->select('id', 'uuid')->get();
        return $this->user->withTrashed()->find($find[0]->id);
    }

    /**
     * Update User
     *
     * @param $data
     * @return User
     */
    public function restore($id)
    {
        $user = $this->user->withTrashed()->find($id);
        $user->restore();
        return $user;
    }
}
