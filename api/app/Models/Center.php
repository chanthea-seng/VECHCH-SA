<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $table = 'centers';

    protected $fillable = ['name', 'local_name'];

    public function departments()
    {
        return $this->hasMany(Department::class, 'center_id', 'id');
    }
    public function doctorProfiles()
    {
        return $this->hasMany(DoctorProfile::class);
    }
}
