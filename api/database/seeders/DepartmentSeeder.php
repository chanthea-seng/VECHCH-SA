<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::insert([
            ['id' => 1, 'name' => 'Cardiology', 'local_name' => 'ជំនាញខាងបេះដូង', 'center_id' => 1],
            ['id' => 2, 'name' => 'Neurology', 'local_name' => 'ជំនាញខាងសរសៃប្រសាទ', 'center_id' => 1],
            ['id' => 3, 'name' => 'Orthopedics', 'local_name' => 'ជំនាញខាងឆ្អឹង', 'center_id' => 2],
            ['id' => 4, 'name' => 'Dermatology', 'local_name' => 'ជំនាញខាងសើស្បែក', 'center_id' => 3],
            ['id' => 5, 'name' => 'Oncology', 'local_name' => 'ជំនាញខាងមហារីក', 'center_id' => 2],
            ['id' => 6, 'name' => 'Pediatrics', 'local_name' => 'ជំនាញខាងកុមារ', 'center_id' => 1],
            ['id' => 7, 'name' => 'Gastroenterology', 'local_name' => 'ជំនាញខាងក្រពះពោះវៀន', 'center_id' => 2],
            ['id' => 8, 'name' => 'Pulmonology', 'local_name' => 'ជំនាញខាងសួត', 'center_id' => 1],
            ['id' => 9, 'name' => 'Urology', 'local_name' => 'ជំនាញខាងប្រព័ន្ធទឹកនោម', 'center_id' => 3],
            ['id' => 10, 'name' => 'Endocrinology', 'local_name' => 'ជំនាញខាងក្រពេញ', 'center_id' => 2],
        ]);
    }
}
