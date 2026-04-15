<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'number_of_seats_booked',
        'booking_status',
        'booking_date',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function isBooked()
    {
        return $this->booking_status === 'booked';
    }

    public function isCancelled()
    {
        return $this->booking_status === 'cancelled';
    }

    public function scopeBooked($query)
    {
        return $query->where('booking_status', 'booked');
    }

    public function scopeCancelled($query)
    {
        return $query->where('booking_status', 'cancelled');
    }
}