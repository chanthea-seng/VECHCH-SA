<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $fillable = [
        'fullname',
        'local_fullname',
        'phone_number',
        'dob',
        'gender',
        'email',
        'password',
        'avatar',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function doctorBookings()
    {
        return $this->hasMany(Booking::class, 'doctor_id');
    }

    public function isDoctor()
    {
        return $this->role_id === 2;
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'doctor_id', 'id');
    }
    public function savedArticles()
    {
        return $this->belongsToMany(Article::class, 'save_articles');
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'user_id', 'id');
    }
    public function doctorEducations()
    {
        return $this->hasMany(DoctorEducation::class);
    }

    public function doctorExperiences()
    {
        return $this->hasMany(DoctorExperience::class);
    }

    public function doctorProfile()
    {
        return $this->hasOne(DoctorProfile::class, 'user_id');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
}
