<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunications extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'title', 'description', 'expiration', 'url', 'icon', 'color', 'progress', 'rol', 'param', 'html', 'json', 'language', 'status'
    ];


    /******************
     * Container with relationships.
     *******************/

    public function files()
    {
        return $this->morphToMany(Files::class, 'fileable');
    }
}
