<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name',
        'local_name',
        'dob',
        'gender',
        'phone_number',
        'email',
        'doctor_id',
        'sub_service_id',
        'appointment_time',
        'description',
        'file',
        'user_id',
        'booking_status',
        'cancelled_at',
        'is_complete',
        'service_type',
        'paymentImage',
    ];

    protected $casts = [
        'dob' => 'date',
        'appointment_time' => 'datetime',
        'is_complete' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function subService()
    {
        return $this->belongsTo(SubService::class);
    }
}
