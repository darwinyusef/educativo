<?php

namespace App\Repositories;

use App\Http\Resources\MultimediaCollection;
use App\Http\Resources\MultimediaResource;
use App\Models\Files;

use Illuminate\Support\Str;

class MultimediaRepository
{
    protected $files;
    protected $paginate = 10;

    /**
     * UserRepository constructor.
     *
     * @param User $files
     */
    public function __construct(Files $files)
    {
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

        return new FilesCollection(
            $this->files
                ->card($request->card)
                ->name($request->name)
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
        return new FilesResource($this->files->find($find[0]->id));
    }


    /**
     * Get files by id + filters
     *
     * @param $id
     * @return mixed
     */
    public function getByIdFilters($id, $request)
    {
        $find = $this->files->find($id);
        if ($request->email != null) {
            $find = $this->files->where('email', $request->email)->get();
            return $this->files->find($find[0]->id);
        }
        return $find;
    }

    /**
     * Save Files
     *
     * @param $data
     * @return Files
     */
    public function save($data)
    {
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
        dd($id);
        $files = $this->files->find($id);
        $files->delete();
        return $files;
    }
}
