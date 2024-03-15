<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'schedules';

    protected $guarded = ['id'];

    protected $fillable = [
        'subject_id',
        'room_id',
        'user_id',
        'year',
        'semester',
        'start_time',
        'end_time',
        'day'
    ];

    public function getTimeAttribute(): string
    {
        return $this->attributes['start_time'] . '-' . $this->attributes['end_time'];
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
