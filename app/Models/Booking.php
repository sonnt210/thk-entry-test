<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $primaryKey = 'booking_id';

    /**
     * @var array
     */
    protected $guarded = ['booking_id'];

    /**
     * Get the hotel that owns the booking.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'hotel_id');
    }
} 