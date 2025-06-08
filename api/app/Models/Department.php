<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'local_name', 'center_id', 'specialist_id'];

    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id', 'id');
    }

    public function specialist()
    {
        return $this->belongsTo(Specialist::class, 'specialist_id', 'id');
    }
    public function doctorProfiles()
    {
        return $this->hasMany(DoctorProfile::class);
    }
}
