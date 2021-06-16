<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunications extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'uuid', 'title', 'description', 'expiration', 'url', 'target', 'icon', 'color', 'progress', 'confParameter', 'rol', 'param', 'html', 'json', 'language', 'status'
    ];



    /******************
     * Container with relationships.
     *******************/

    public function files()
    {
        return $this->morphToMany(Files::class, 'fileable');
    }
}
