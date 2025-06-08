<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DoctorProfile;

class DoctorProfileSeeder extends Seeder
{
    public function run(): void
    {
        $doctorProfiles = [
            [
                "user_id" => 2,
                "biography" => "Experienced cardiologist with over 10 years in practice.",
                "spoken_languages" => ["English", "French"],
                "specialist_id" => 2,
                "department_id" => 2,
                "center_id" => 1,
                "is_verify" => 1,
                "is_author" => true
            ],
            [
                "user_id" => 5,
                "biography" => "Neurologist specializing in stroke recovery.",
                "spoken_languages" => ["English", "Vietnamese"],
                "specialist_id" => 5,
                "department_id" => 4,
                "center_id" => 3,
                "is_verify" => 1,
                "is_author" => false
            ],
            [
                "user_id" => 6,
                "biography" => "ENT specialist with expertise in sinus surgery.",
                "spoken_languages" => ["English", "Khmer"],
                "specialist_id" => 8,
                "department_id" => 8,
                "center_id" => 2,
                "is_verify" => 1,
                "is_author" => false
            ],
            [
                "user_id" => 11,
                "biography" => "Psychiatrist focused on adolescent mental health.",
                "spoken_languages" => ["English", "French"],
                "specialist_id" => 9,
                "department_id" => 9,
                "center_id" => 1,
                "is_verify" => 1,
                "is_author" => true
            ],
            [
                "user_id" => 12,
                "biography" => "Orthopedic surgeon with expertise in joint replacement.",
                "spoken_languages" => ["English", "Thai"],
                "specialist_id" => 4,
                "department_id" => 3,
                "center_id" => 1,
                "is_verify" => 1,
                "is_author" => true
            ],
        ];

        foreach ($doctorProfiles as $profile) {
            DoctorProfile::create([
                'user_id' => $profile['user_id'],
                'biography' => $profile['biography'],
                'spoken_languages' => json_encode($profile['spoken_languages']),
                'specialist_id' => $profile['specialist_id'],
                'department_id' => $profile['department_id'],
                'center_id' => $profile['center_id'],
                'is_author' => $profile['is_author'],
                'is_verify' => $profile['is_verify'],

            ]);
        }
    }
}
