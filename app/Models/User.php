<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \Laravel\Sanctum\HasApiTokens;
use \Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','uuid', 'name', 'lastname', 'cardId', 'email', 'mobile', 'displayName', 'LastMs', 'slug', 'nickname', 'about', 'temporalTocken', 'onlyDelete', 'town', 'photo', 'especialParam', 'pago', 'email_verified_at', 'password', 'language',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /******************
     * Container with relationships.
     *******************/

    public function files()
    {
        return $this->morphToMany(Files::class, 'fileable');
    }


    /******************
     * Container with scopes.
     *******************/

    public function scopeUuid($query, $uuid)
    {
        if ($uuid != "") {
            $query->where("uuid", 'LIKE' ,"%$uuid%");
        }
    }
    public function scopeCard($query, $number)
    {
        if ($number != "") {
            if (is_numeric($number)) {
                $query->where('cardId', $number);
            }
        }
    }

    public function scopeName($query, $totalName)
    {
        if ($totalName != "") {
            $query->where(DB::raw("CONCAT(name, ' ', lastname)"), 'LIKE',  "%$totalName%");
        }
    }
}
