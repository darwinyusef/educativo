<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Params extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',  'uuid', 'param_key', 'param_value', 'slug', 'settings', 'url', 'value', 'time_in', 'time_out', 'context', 'autoload', 'frecuency', 'parent', 'especial', 'html', 'json', 'language', 'status'
    ];


    /******************
     * Container with relationships.
     *******************/

    public function files()
    {
        return $this->morphToMany(Files::class, 'fileable');
    }
}
