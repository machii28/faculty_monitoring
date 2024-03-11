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

    public function getBookedDateAttribute(): string
    {
        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();

        $booking = Booking::whereBetween('booking_date', [$startDate, $endDate])
            ->where('subject_id', $this->attributes['subject_id'])
            ->where('room_id', $this->attributes['room_id'])
            ->first();

        return $booking->booking_date . '(' . Carbon::parse($booking->booking_date)->format('l') . ')' . ' | ' . $booking->start_booking_time . ' - ' . $booking->end_booking_time;
    }

    public function getAttendedAttribute(): bool
    {
        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();

        $booking = Booking::whereBetween('booking_date', [$startDate, $endDate])
            ->where('subject_id', $this->attributes['subject_id'])
            ->where('room_id', $this->attributes['room_id'])
            ->first();

        if (Carbon::parse($booking->booking_date)->format('l') === $this->attributes['day']) {
            return true;
        }

        return false;
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
