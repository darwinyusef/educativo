<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
// Call models
use App\Models\User;
use App\Models\Comunications;
use App\Models\Content;
use App\Models\Course;
use App\Models\Files;
use App\Models\Interactions;
use App\Models\Links;
use App\Models\Params;
use App\Models\Post;
use App\Models\Taxonomies;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Exception;

class ModelService
{

    public function assing($model, $id_model)
    {
        switch ($model) {
            case 'user':
                $modelData = User::find($id_model);
                break;
            case 'post':
                $modelData = Post::find($id_model);
                break;
            case 'link':
                $modelData = Links::find($id_model);
                break;
            case 'params':
                $modelData = Params::find($id_model);
                break;
            case 'taxonomies':
                $modelData = Taxonomies::find($id_model);
                break;
            case 'comunications':
                $modelData = Comunications::find($id_model);
                break;
            case 'content':
                $modelData = Content::find($id_model);
                break;
            case 'course':
                $modelData = Course::find($id_model);
                break;
            case 'interactions':
                $modelData = Interactions::find($id_model);
                break;
            case 'files':
                $modelData = Interactions::find($id_model);
                break;
            default:
                $modelData = null;
                break;
        }

        return $modelData;
    }


    public function chargueModels($data)
    {
        //valida si el documento se encuentra ya se encuentra
        if (!$data->model) {
            //crea el elemento en la tabla polymorfica
            DB::table(strval($data->table . 'ables'))->insert([
                strval($data->table . 's_id') => $data->id_table,
                strval($data->table . 'able_id') => $data->id_model,
                strval($data->table . 'able_type') => $data->model,
                strval($data->table . 'created_at') => Carbon::now(),
                strval($data->table . 'updated_at') => Carbon::now(),
            ]);

            return true;
        } else {
            return false;
        }
    }
}
