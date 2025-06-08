<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialist_id',
        'organization_name',
        'position',
        'responsibilities',
        'start_date',
        'end_date',
        'is_current',
        'location',
        'is_verified',
    ];

    public  $timestamps = false;
    protected $casts = [
        'is_current' => 'boolean',
        'is_verified' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Specialist
    public function specialist()
    {
        return $this->belongsTo(Specialist::class);
    }
}
