<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DispositionDocument extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'index',
        'letter_type',
        'code',
        'date_finish',
        'date_number',
        'from',
        'resume_content',
        'agenda_number',
        'agenda_date',
        'status',
        'uploaded_document',
        'document_id'
    ];

    protected $dates = ['deleted_at'];

    public function disposition_user()
    {
        return $this->hasMany(DispositionUser::class, 'disposition_document_id', 'id');
    }
}
