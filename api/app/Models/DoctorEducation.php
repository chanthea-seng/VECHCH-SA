<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorEducation extends Model
{
    protected $table = 'doctor_educations';

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'institution_name',
        'location',
        'degree_name',
        'start_date',
        'end_date'
    ];

    protected $dates = [
        'start_date' => 'data',
        'end_date' => 'data'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
