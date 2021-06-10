<?php

namespace App\Repositories;

use App\Http\Resources\MultimediaCollection;
use App\Http\Resources\MultimediaResource;

use App\Services\ModelService;

use App\Models\Files;
use App\Models\User;

use Illuminate\Support\Str;

class MultimediaRepository
{
    protected $users;
    protected $files;
    protected $paginate = 10;

    /**
     * UserRepository constructor.
     *
     * @param User $files
     */
    public function __construct(Files $files, User $users)
    {
        $this->users = $users;
        $this->files = $files;
        $this->paginate = 10;
    }

    /**
     * Get all filess + Filters.
     *
     * @return Files $files
     */
    public function getAll($request)
    {
        if ($request->paginate) {
            $this->paginate = $request->paginate;
        }

        return new MultimediaCollection(
            $this->files
                ->file($request->title)
                ->typeFile($request->mimes)
                ->paginate($this->paginate)
        );
    }

    /**
     * Get files by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $find = $this->files->uuid($id)->select('id', 'uuid')->get();
        return new MultimediaResource($this->files->find($find[0]->id));
    }


    /**
     * Save Files
     *
     * @param $data
     * @return Files
     */
    public function save($data)
    {
        $model = $data['model'];

        $files = new $this->files;

        $files->uuid = Str::uuid();
        $files->file = $data['file'];
        $files->description = $data['description'];
        $files->url = config(str_replace('%storage%', $data['storage'], 'filesystems.disks.%storage%.url')) . '/ac' . $data['finalName'];
        //  $files->expiration = $data['expiration'] ? null : $data['expiration'];
        $files->type_file = $data['all_files']->getClientOriginalExtension();
        $files->file_location = str_replace(env('APP_URL'), '', config(str_replace('%storage%', $data['storage'], 'filesystems.disks.%storage%.url')))  . '/ac' . $data['finalName'];
        $files->storage = $data['storage'];
        $files->language = $data['language'];
        $files->status = 1;
        $files->save();

        if ($model != null) {
            $arrayModel = explode('|', $model);
            // llamamos el servicio de models este nos genera una creación en todas las tablas de tipo ++able
            $modelService = new ModelService;
            $modelData = $modelService->assing($arrayModel[0], $files->save()->id);
            $consult = [
                'table' => 'file',
                'id_table' => $files->save()->id,
                'id_model' => $arrayModel[1],
                'model' => get_class($modelData)
            ];
            $modelService->chargueModels($consult);
        }

        return $files->fresh();
    }


    /**
     * Update Files
     *
     * @param $data
     * @return Files
     */
    public function delete($id)
    {
        $files = $this->files->find($id);
        $files->delete();

        return $files;
    }
}
