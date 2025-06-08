<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'biography',
        'spoken_languages',
        'is_author',
        'specialist_id',
        'department_id',
        'center_id',
        'status',
        'is_verify'
    ];

    protected $casts = [
        'spoken_languages' => 'array',
        'is_author' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function specialist()
    {
        return $this->belongsTo(Specialist::class, 'specialist_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id');
    }
}
