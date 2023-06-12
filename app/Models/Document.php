<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Document extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'applicant_id',
        'name',
        'document_category_id',
        'status',
        'notes',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function doc_req()
    {
        return $this->hasMany(DocumentRequirement::class, 'document_id', 'id');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
        ->diffForHumans();
    }
}
