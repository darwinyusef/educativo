<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'content', 'description', 'slug', 'password', 'calification', 'excerpt', 'view', 'order', 'urlInbox', 'timeIn', 'timeOut', 'confParameter', 'assing', 'classroom', 'classroomText', 'address', 'timeLine', 'meta', 'json', 'html', 'status', 'parent', 'language'
    ];


    /******************
     * Container with relationships.
     *******************/

    public function files()
    {
        return $this->morphToMany(Files::class, 'fileable');
    }
}
