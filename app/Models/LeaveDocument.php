<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveDocument extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes;

    public $incrementing = false;

    public $keyType = 'string';

    protected $fillable = [
        'letter_head',
        'unit_id',
        'leave_long',
        'address',
        'phone',
        'permit_type',
        'user_id',
        'start_time',
        'end_time',
        'reason',
        'working_time',
        'status',
        'signature',
    ];

    protected $dates = ['deleted_at'];
}
