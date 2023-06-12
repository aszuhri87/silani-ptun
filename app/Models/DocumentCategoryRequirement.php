<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentCategoryRequirement extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'document_category_id',
        'requirement_type',
        'requirement',
        'required',
        'data_min',
        'data_max',
        'description',
    ];

    protected $dates = ['deleted_at'];
}
