<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;
    use HasRoles;
    use HasApiTokens;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'name',
        'address',
        'user_id',
        'role',
        'image',
    ];

    protected $dates = ['deleted_at'];
}
