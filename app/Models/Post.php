<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'slug', 'excerpt', 'title', 'content', 'views', 'password', 'url', 'context', 'state', 'time_in', 'time_out', 'parent', 'user_id', 'notification', 'meta', 'json', 'html', 'status', 'parent', 'language'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->morphToMany(Files::class, 'fileable');
    }

    public function taxonomy()
    {
        return $this->morphToMany(Taxonomies::class, 'taxonoable');
    }

    public function scopeUuid($query, $uuid)
    {
        if ($uuid != "") {
            $query->where("uuid", 'LIKE' ,"%$uuid%");
        }
    }

    public function scopeContext($query, $context)
    {
        if ($context != "") {
            $query->where('context', "$context");
        }
    }


    public function scopeTitle($query, $title)
    {
        if ($title != "") {
            $query->where('title', 'LIKE', "%$title%")->orWhere('content', 'LIKE', "%$title%");
        }
    }
}
