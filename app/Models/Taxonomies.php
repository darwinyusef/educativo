<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomies extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'slug', 'taxonomy', 'description', 'meta', 'type', 'parent', 'html', 'json', 'language', 'status',
    ];
}
