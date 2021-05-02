<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'uuid', 'slug', 'excerpt', 'title', 'content', 'views', 'password', 'url', 'context', 'state', 'time_in', 'time_out', 'parent', 'user_id', 'notification', 'meta', 'json', 'html', 'status', 'parent', 'language'
    ];

    public function getRouteKeyName(){
        return 'slug';
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function files() {
          return $this->morphToMany(Files::class, 'fileable');
    }

    public function taxonomy() {
          return $this->morphToMany(Taxonomies::class, 'taxonoable');
    }

}
