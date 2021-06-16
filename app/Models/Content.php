<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',  'uuid', 'content', 'description', 'slug', 'password', 'value', 'rating', 'excerpt', 'view', 'order', 'urlInbox', 'timeIn', 'timeOut', 'confParameter', 'rol', 'assing', 'classroom', 'classroomText', 'address', 'timeLine', 'send', 'meta', 'json', 'html', 'status', 'parent', 'language'
    ];

    /******************
     * Container with relationships.
     *******************/

    public function files()
    {
        return $this->morphToMany(Files::class, 'fileable');
    }
}
