<?php

namespace App\Services;

use App\Repositories\MultimediaRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\HelperController;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Exception, InvalidArgumentException;

class MultimediaService
{

    private $multimediaRepository;

    public function __construct(MultimediaRepository $multimediaRepository)
    {
        $this->multimediaRepository = $multimediaRepository;
    }

    /**
     *  Carga el archivo
     */
    static public function chargueFile($input_name, $request, $diskList)
    {
        $file = $request->file($input_name);
        $dt = Carbon::now();
        //se modifica el archivo colocando el día el mes el año el minuto y el segundo
        $carbon = $dt->day . $dt->month . $dt->year . $dt->hour . $dt->minute . $dt->second;
        //obtenemos el nombre del archivo
        $nombre = $file->getClientOriginalName();

        // hace la selección de la carpeta donde se ha de incluir
        if (in_array($request->storage, $diskList)) {
            $disk = $request->storage;
        } else {
            $disk = 'public';
        }

        //indicamos que queremos guardar un nuevo archivo en el disco local
        Storage::disk($disk)->put($nombre,  File::get($file));
        //verificamos si el archivo existe y lo retornamos como un fecha actual + xid 6 aleatorio + extención
        $name = $carbon . Str::slug(rand(10000000, 999999999), "") . '.' . $file->getClientOriginalExtension();
        // hacemos el move del doc cargado
        Storage::disk($disk)->move($nombre, 'ac' . $name);

        return $name;
    }

    /**
     * Carga la información a la BD con el archivo ya incluido
     */
    public function chargueFileBD($request, $finalName)
    {
        $listOnly = [
            'all_files', 'file', 'description', 'url', 'expiration', 'type_file', 'file_location',
            'storage', 'language', 'status'
        ];

        $data = $request->only($listOnly);
        $data = Arr::add($data, 'finalName', $finalName);

        $validator = Validator::make($data, [
            'all_files' => 'mimes:' . $request->mimes,
            'file' => 'required',
            'storage' => 'required'
        ]);

        if ($validator->fails()) {
            $mensaje = $validator->errors()->first();
            throw ValidationException::withMessages(['status' => 400, 'errors' => $mensaje, 'data' => $data])->status(400);
        }


        DB::beginTransaction();
        try {
            $this->multimediaRepository->save($data);
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException($e.' No se a actualizado el documento pero se ha cargado correctamente el archivo');
        }
        DB::commit();
    }


    public function selectTypeFiles()
    {
        foreach (config('paramslist.disk:files') as $key => $value) {
            if ($value) {
                $data[] = $key;
            }
        }
        return $data;
    }


    static public function updateFile(
        $input_,
        $request
    ) {
        $file = $request->file($input_name);
        $archivo = $request['imgOld'];

        if (isset($file)) {
            $dt = Carbon::now();
            //se modifica el archivo colocando el día el mes el año el minuto y el segundo
            $carbon = $dt->day . $dt->month . $dt->year . $dt->hour . $dt->minute . $dt->second;
            //obtenemos el nombre del archivo
            $nombre = $file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            Storage::disk('local')->put($nombre,  File::get($file));
            //verificamos si el archivo existe y lo retornamos
            $name = $carbon . '.' . $file->getClientOriginalExtension();
            Storage::move($nombre, 'ac' . $name);
            /** se valida que existe el archivo con info old */
            if (Storage::exists(Str::replaceFirst('files/', '', $archivo)) && $archivo != null) {

                // $oldfile = MasterFiles::where('url', 'LIKE', "%" . $archivo . "%")->first();
                Storage::delete(Str::replaceFirst('files/', '', $oldfile->url));
                // $oldfile->forceDelete();
            }
        }
        return $name;
    }


     /**
     * Delete post by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            HelperController::validateUuid($id);
            $findMultimedia = $this->multimediaRepository->getById($id);
            $file = $this->postRepository->delete( $findMultimedia->id );
        } catch (Exception $e) {
            DB::rollBack();
            throw new InvalidArgumentException($e . 'Al borrar el archivo');
        }
        DB::commit();
        return $file;
    }



    static public function deleteFile($request)
    {
        dd($request);
        $archivo = $request['url'];
        if (Storage::exists(Str::replaceFirst('files/', '', $archivo)) && $archivo != null) {
            Storage::delete(Str::replaceFirst('files/', '', $archivo));
            // $master = MasterFiles::findOrFail($request['id']);
            $master->forceDelete();
        }
    }
}
