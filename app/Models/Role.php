<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    use Uuid;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'name',
        'guard_name',
    ];

    protected $casts = [
        'role_id' => 'string',
      ];
}
