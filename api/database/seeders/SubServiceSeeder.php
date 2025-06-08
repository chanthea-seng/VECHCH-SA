<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubServiceSeeder extends Seeder
{
    public function run()
    {
        $subServices = [
            [
                'service_id' => 1,
                'description' => "គ្រាប់ឈាម ស ក្រហម(CBC),ខ្លាញ់ក្នុងសសៃឈាម Triglycerides, ខ្លាញ់បេះដូង Total Cholesterol, ខ្លាញ់ល្អ HDL Cholesterol ,ខ្លាញ់អាក្រក់ LDL Cholesterol, ជាតិប្រៃ Albumin ,ជាតិកាល់ស្យូម Calcium ,ជាតិអេឡិកត្រូលីត Ionogramme, មុខងារតំរងនោម (BUN)  ,ជាតិស្ករ Glucose ,មុខងារតំរងនោម Creatinine, អាស៊ីតអ៊ុយរីក Uric acid ,ជាតိប្រូតេអ៊ីន Protein, total មុខងារថ្លើម Transaminase (AST; ALT) មុខងារថ្លើម GGT",
                'local_description' => 'គ្រាប់ឈាម ស ក្រហម(CBC),ខ្លាញ់ក្នុងសសៃឈាម Triglycerides, ខ្លាញ់បេះដូង Total Cholesterol, ខ្លាញ់ល្អ HDL Cholesterol ,ខ្លាញ់អាក្រក់ LDL Cholesterol, ជាតិប្រៃ Albumin ,ជាតិកាល់ស្យូម Calcium ,ជាតិអេឡិកត្រូលីត Ionogramme, មុខងារតំរងនោម (BUN)  ,ជាតិស្ករ Glucose ,មុខងារតំរងនោម Creatinine, អាស៊ីតអ៊ុយរីក Uric acid ,ជាតិប្រូតេអ៊ីន Protein, total មុខងារថ្លើម Transaminase (AST; ALT) មុខងារថ្លើម GGT',
                'price' => 23.00,
                'is_active' => true,
            ],
            [
                'service_id' => 2,
                'description' => 'Physical Examination ,Blood Pressure Monitoring ,Body Mass Index (BMI) & Waist-Hip Ratio Measurement, Pulse Oximetry Test',
                'local_description' => 'Physical Examination ,Blood Pressure Monitoring ,Body Mass Index (BMI)Waist-Hip Ratio Measurement, Pulse Oximetry Test',
                'price' => 120.00,
                'is_active' => true,
            ],
            [
                'service_id' => 2,
                'description' => 'Fasting Blood Sugar, HbA1c Test, Lipid Profile (Cholesterol Test) ,Kidney Function Test, Liver Function Test, Thyroid Function Test, Electrolyte Imbalance',
                'local_description' => 'Fasting Blood Sugar, HbA1c Test, Lipid Profile (Cholesterol Test) ,Kidney Function Test, Liver Function Test, Thyroid Function Test, Electrolyte Imbalance',
                'price' => 200.00,
                'is_active' => true,
            ],
            [
                'service_id' => 2,
                'description' => 'ECG (Electrocardiogram), Abdominal Ultrasound, Retinal Eye Exam, Foot Examination (for diabetics)',
                'local_description' => 'ECG (Electrocardiogram), Abdominal Ultrasound, Retinal Eye Exam, Foot Examination (for diabetics)',
                'price' => 270.00,
                'is_active' => true,
            ],
            [
                'service_id' => 3,
                'description' => 'CBC (to detect anemia or abnormal cells), ESR (inflammation marker), Liver Function Test (LFT) ,Chest X-ray (Lung abnormalities) ,Stool Occult Blood Test (colon cancer risk)',
                'local_description' => 'CBC (to detect anemia or abnormal cells), ESR (inflammation marker), Liver Function Test (LFT) ,Chest X-ray (Lung abnormalities) ,Stool Occult Blood Test (colon cancer risk)',
                'price' => 70.00,
                'is_active' => true,
            ],
            [
                'service_id' => 3,
                'description' => 'Pap Smear (Cervical cancer) ,HPV DNA Test (if needed), Breast Examination by Doctor, Breast Ultrasound / Mammogram (depending on age), Pelvic Ultrasound',
                'local_description' => 'Pap Smear (Cervical cancer) ,HPV DNA Test (if needed), Breast Examination by Doctor, Breast Ultrasound / Mammogram (depending on age), Pelvic Ultrasound',
                'price' => 150.00,
                'is_active' => true,
            ],
            [
                'service_id' => 3,
                'description' => 'Digital Rectal Exam (DRE), Chest X-ray (lung cancer risk) ,Ultrasound Abdomen CBC & Liver Profile',
                'local_description' => 'Digital Rectal Exam (DRE), Chest X-ray (lung cancer risk) ,Ultrasound Abdomen CBC & Liver Profile',
                'price' => 140.00,
                'is_active' => true,
            ],
            [
                'service_id' => 4,
                'description' => 'Tdap (Tetanus; Diphtheria; Pertussis) – 1 dose ,Hepatitis B – 3 doses ,Influenza (Flu) – annual',
                'local_description' => 'Tdap (Tetanus; Diphtheria; Pertussis) – 1 dose ,Hepatitis B – 3 doses ,Influenza (Flu) – annual',
                'price' => 130.00,
                'is_active' => true,
            ],
            [
                'service_id' => 4,
                'description' => 'Typhoid (Injectable) – 1 dose , Hepatitis A & B (Twinrix or separate) – 3 doses  ,Yellow Fever (if required) – 1 dose , Meningococcal ACYW – 1 dose',
                'local_description' => 'Typhoid (Injectable) – 1 dose , Hepatitis A & B (Twinrix or separate) – 3 doses  ,Yellow Fever (if required) – 1 dose , Meningococcal ACYW – 1 dose',
                'price' => 280.00,
                'is_active' => true,
            ],
            [
                'service_id' => 5,
                'description' => 'Hepatitis B (Birth - 6 weeks - 14 weeks),  DTP (6-10-14 weeks) ,IPV (6-10-14 weeks) ,Hib (6-10-14 weeks) ,Oral Polio Vaccine ',
                'local_description' => 'Typhoid (Injectable) – 1 dose , Hepatitis A & B (Twinrix or separate) – 3 doses  ,Yellow Fever (if required) – 1 dose , Meningococcal ACYW – 1 dose',
                'price' => 20.00,
                'is_active' => true,
            ],
            [
                'service_id' => 5,
                'description' => 'Meningococcal (optional): $90,  Influenza (from 6 months): $30  ,Pediatric consultation at each visit: $25 x 6 = $150 , Growth & development screening',
                'local_description' => 'Meningococcal (optional): $90,  Influenza (from 6 months): $30  ,Pediatric consultation at each visit: $25 x 6 = $150 , Growth & development screening',
                'price' => 580.00,
                'is_active' => true,
            ],
            [
                'service_id' => 5,
                'description' => 'BCG  Hepatitis B (3 doses) , DTaP-IPV-Hib (Pentavalent combo – 3 doses),  PCV (Pneumococcal) – 3 doses , Rotavirus (oral) – 2 or 3 doses depending on brand',
                'local_description' => 'BCG  Hepatitis B (3 doses) , DTaP-IPV-Hib (Pentavalent combo – 3 doses),  PCV (Pneumococcal) – 3 doses , Rotavirus (oral) – 2 or 3 doses depending on brand',
                'price' => 580.00,
                'is_active' => true,
            ],
        ];

        foreach ($subServices as $subService) {
            DB::table('sub_services')->insert($subService);
        }
    }
}
