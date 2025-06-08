<?php

namespace Database\Seeders;

use App\Models\Center;
use Illuminate\Database\Seeder;

class CenterSeeder extends Seeder
{
    public function run(): void
    {
        Center::insert([
            ['id' => 1, 'name' => 'City Hospital', 'local_name' => 'មន្ទីរពេទ្យទីក្រុង'],
            ['id' => 2, 'name' => 'Regional Medical Center', 'local_name' => 'មជ្ឈមណ្ឌលវេជ្ជសាស្ត្រតំបន់'],
            ['id' => 3, 'name' => 'Specialty Clinic', 'local_name' => 'គ្លីនិកឯកទេស'],
            ['id' => 4, 'name' => 'Community Health Center', 'local_name' => 'មណ្ឌលសុខភាពសហគមន៍'],
        ]);
    }
}
