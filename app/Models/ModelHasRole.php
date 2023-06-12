<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRole extends Model
{
    use HasFactory;
    use Uuid;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'model_id',
        'model_type',
        'role_id',
    ];

    protected $casts = [
        'role_id' => 'string',
      ];
}
