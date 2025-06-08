<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    public $timestamps = false;
    protected $table = 'specialists';
    protected $fillable = ['name', 'local_name', 'specialist_id'];

    
    public function department()
    {
        return $this->hasMany(Department::class, 'specialist_id', 'id');
    }
    public function doctorExperiences()
    {
        return $this->hasMany(DoctorExperience::class);
    }

    public function doctorProfiles()
    {
        return $this->hasMany(DoctorProfile::class);
    }
}
