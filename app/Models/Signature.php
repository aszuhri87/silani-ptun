<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signature extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'photo',
        'user_id',
    ];

    protected $dates = ['deleted_at'];
}
