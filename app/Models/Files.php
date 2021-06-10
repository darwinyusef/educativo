<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Files extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'file', 'description',
        'url', 'expiration', 'type_file', 'file_location', 'selecction',
        'storage', 'parent', 'html', 'json', 'language', 'status'
    ];

    /******************
     * Container with scopes.
     *******************/

    public function scopeUuid($query, $uuid)
    {
        if ($uuid != "") {
            $query->where("uuid", 'LIKE', "%$uuid%");
        }
    }

    public function scopeFile($query, $file)
    {
        if ($file != "") {
            $query->where("file", 'LIKE', "%$file%")->orWhere("description", 'LIKE', "%$file%");
        }
    }

    public function scopeTypeFile($query, $typeFile)
    {
        if ($typeFile != "") {
            $query->where("type_file", 'LIKE', "%$typeFile%");
        }
    }




    /******************
     * Container with relationships.
     *******************/

    public function user()
    {
        return $this->morphedByMany(User::class, 'fileable');
    }

    public function comunications()
    {
        return $this->morphedByMany(Comunications::class, 'fileable');
    }

    public function course()
    {
        return $this->morphedByMany(Course::class, 'fileable');
    }

    public function content()
    {
        return $this->morphedByMany(Content::class, 'fileable');
    }

    public function interactions()
    {
        return $this->morphedByMany(Interactions::class, 'fileable');
    }

    public function links()
    {
        return $this->morphedByMany(Links::class, 'fileable');
    }

    public function paramas()
    {
        return $this->morphedByMany(Params::class, 'fileable');
    }

    public function post()
    {
        return $this->morphedByMany(Post::class, 'fileable');
    }

    public function taxonomies()
    {
        return $this->morphedByMany(Taxonomies::class, 'fileable');
    }
}
