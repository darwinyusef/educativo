<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'interaction', 'response', 'context', 'value', 'notification', 'users_id', 'courses_id',
    ];
}
