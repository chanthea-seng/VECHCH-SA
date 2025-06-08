<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'booking_id',
        'doctor_id',
        'message'
    ];

    protected $casts = [
        'notes' => 'array'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class, 'medical_record_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'medical_record_id');
    }
}
