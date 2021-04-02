<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid', 'slug', 'excerpt', 'course', 'description', 'classroom', 'level', 'descriptionTask', 'amountTask', 'calification', 'subject', 'notification', 'meta', 'json', 'html', 'status', 'parent', 'language'
    ];

}
