<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Applicant extends Authenticatable
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;
    use HasRoles;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'name',
        'nik',
        'gender',
        'address',
        'user_id',
        'phone_number',
        'image',
    ];

    protected $dates = ['deleted_at'];

        public function getCreatedAtAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->attributes['created_at'])
        ->diffForHumans();
    }
}
