<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CenterSeeder::class,
            DepartmentSeeder::class,
            SpecialistSeeder::class,
            ServiceSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            ArticleSeeder::class,
            SubServiceSeeder::class,
            BookingSeeder::class,
            DoctorProfileSeeder::class,
            ArticleTagSeeder::class,
            ContactSeeder::class
        ]);
    }
}
