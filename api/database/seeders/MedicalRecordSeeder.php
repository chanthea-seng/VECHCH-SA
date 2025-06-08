<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Examination;
use App\Models\Prescription;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 13; $i++) {
            // Create the medical record
            $record = MedicalRecord::create([
                'booking_id' => $i, // Assumes booking IDs 1–13 exist
                'doctor_id' => 2,   // Doctor with ID 2
                'message' => "Patient visited for routine checkup (Booking #$i).",
            ]);

            // Create the examination note
            Examination::create([
                'medical_record_id' => $record->id,
                'name' => 'Blood Pressure',
                'result' => '120/80 mmHg',
                'status' => 'Normal',
            ]);

            // Create the prescription note
            Prescription::create([
                'medical_record_id' => $record->id,
                'name' => 'Ibuprofen',
                'dosage' => '200 mg',
                'frequency' => 'Twice daily',
                'duration' => '5 days',
            ]);
        }
    }
}

// php artisan db:seed --class=MedicalRecordSeeder
