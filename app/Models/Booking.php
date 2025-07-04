<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'timeslot_id',
        'people',
        'status',          // pending | paid | cancelled
        'amount',          // decimal 8,2
        'payment_intent_id',
    ];

    protected $casts = [
        'people' => 'integer',
        'amount' => 'decimal:2',
    ];

    /* ----------------------------------------------------------
     | Relationships
     |----------------------------------------------------------*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function services()
    {
        // if your pivot table is booking_service the default name is fine
        return $this->belongsToMany(Service::class)
            ->withPivot(['quantity', 'price_each', 'line_total'])
            ->withTimestamps();
    }

    /* ----------------------------------------------------------
     | Helpers
     |----------------------------------------------------------*/
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /** Human-readable booking reference */
    public function getRefAttribute(): string
    {
        return 'HH-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
