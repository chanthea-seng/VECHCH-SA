<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Seeder;

class SpecialistSeeder extends Seeder
{
    public function run(): void
    {
        $dataSpecialist = [
            ['id' => 1, 'name' => 'General Practitioner', 'local_name' => 'គ្រូពេទ្យទូទៅ'],
            ['id' => 2, 'name' => 'Cardiologist', 'local_name' => 'គ្រូពេទ្យជំនាញខាងបេះដូង'],
            ['id' => 3, 'name' => 'Pediatrician', 'local_name' => 'គ្រូពេទ្យកុមារ'],
            ['id' => 4, 'name' => 'Orthopedic Surgeon', 'local_name' => 'គ្រូពេទ្យវះកាត់ឆ្អឹង'],
            ['id' => 5, 'name' => 'Neurologist', 'local_name' => 'គ្រូពេទ្យជំនាញខាងសរសៃប្រសាទ'],
            ['id' => 6, 'name' => 'Oncologist', 'local_name' => 'គ្រូពេទ្យជំនាញខាងមហារីក'],
            ['id' => 7, 'name' => 'Dermatologist', 'local_name' => 'គ្រូពេទ្យសើស្បែក'],
            ['id' => 8, 'name' => 'ENT Specialist', 'local_name' => 'ជំនាញខាងត្រចៀក ច្រមុះ បំពង់ក'],
            ['id' => 9, 'name' => 'Psychiatrist', 'local_name' => 'គ្រូពេទ្យផ្លូវចិត្ត'],
            ['id' => 10, 'name' => 'Gastroenterologist', 'local_name' => 'គ្រូពេទ្យជំនាញខាងក្រពះពោះវៀន'],
        ];

        foreach ($dataSpecialist as $data) {
            $specialist = new Specialist();
            $specialist->id = $data['id'];
            $specialist->name = $data['name'];
            $specialist->local_name = $data['local_name'];
            $specialist->save();
        }
    }
}
