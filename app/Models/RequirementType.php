<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequirementType extends Model
{
    use HasFactory;

    use SoftDeletes;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'requirement_type',
        'description',
        'data_type',
        'data_unit',
    ];

    protected $dates = ['deleted_at'];
}
