<?php

namespace App\Models;

use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExitPermitDocument extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'notes',
        'user_id',
        'unit_id',
        'datetime',
        'reason',
        'signature',
        'approver',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['datetime'])->locale('id')
        ->diffForHumans();
    }
}
