<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'uuid', 'slug', 'interaction', 'response', 'context', 'value', 'rating', 'confParameter', 'rol', 'notification', 'meta', 'json', 'html', 'status', 'parent', 'language'
    ];

    /******************
     * Container with relationships.
     *******************/

    public function files()
    {
        return $this->morphToMany(Files::class, 'fileable');
    }
}
