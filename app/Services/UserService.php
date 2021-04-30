<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HelperController;

use InvalidArgumentException;

class UserService
{
    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all user.
     *
     * @return String
     */
    public function getAll($request)
    {
        return $this->userRepository->getAll($request);
    }

    /**
     * Get user by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        HelperController::validateUuid($id);
        return $this->userRepository->getById($id);
    }

    /**
     * Update user data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateUser($data, $id)
    {

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'cardId' => 'required|numeric',
            'mobile' => 'required|numeric',
            'nicname' => 'required'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();
        try {
            HelperController::validateUuid($id);
            $findUser = $this->userRepository->getById($id);
            $user = $this->userRepository->update($data, $findUser->id);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('No se a actualizado la data');
        }

        DB::commit();

        return $user;
    }

    /**
     * Validate user data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveUserData($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'cardId' => 'required|numeric',
            'email' => 'required|unique:users|email',
            'mobile' => 'required|numeric',
            'nicname' => 'required',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->userRepository->save($data);

        return $result;
    }


    /**
     * Delete user by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($data, $id)
    {
        DB::beginTransaction();
        try {
            HelperController::validateUuid($id);
            $findUser = $this->userRepository->getById($id);
            if($data == []){
                $data['deleteForever'] = 'no';
                $user = $this->userRepository->delete($findUser->id);
            }

            if( $data['deleteForever'] == 'si'){
                $user = $this->userRepository->totalDelete($findUser->id);
            }


        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException($e.'Al borrar el usuario');
        }

        DB::commit();

        return $user;
    }

    /**
     * Restore user by id.
     *
     * @param $id
     * @return String
     */
    public function restoreById($id)
    {
        DB::beginTransaction();

        try {
            HelperController::validateUuid($id);
            $findUser = $this->userRepository->getById($id);
            $user = $this->userRepository->restore($findUser->id);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException('Al restaurar el usuario');
        }

        DB::commit();

        return $user;
    }
}
