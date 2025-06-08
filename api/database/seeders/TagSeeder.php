<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $datatag = [
            [
                'name' => 'wealth & wellness',
                'local_name' => 'សុខភាព និងសម្រស់',
                'content_type' => 1
            ],
            [
                'name' => 'nutrition',
                'local_name' => 'អាហារូបត្ថម្ភ',
                'content_type' => 1
            ],
            [
                'name' => 'fitness',
                'local_name' => 'សុខភាពសម្បទា',
                'content_type' => 1
            ],
            [
                'name' => 'medical research',
                'local_name' => 'ការស្រាវជ្រាវវេជ្ជសាស្រ្ត',
                'content_type' => 1
            ],
            [
                'name' => 'healthy living',
                'local_name' => 'ការរស់នៅប្រកបដោយសុខភាព',
                'content_type' => 1
            ],
            [
                'name' => 'preventive care',
                'local_name' => 'ការថែទាំបង្ការ',
                'content_type' => 1
            ],
            [
                'name' => 'weight management',
                'local_name' => 'ការគ្រប់គ្រងទម្ងន់',
                'content_type' => 1
            ],
            [
                'name' => 'self care',
                'local_name' => 'ការថែរក្សាខ្លួនឯង',
                'content_type' => 1
            ],
            [
                'name' => 'public health',
                'local_name' => 'សុខភាពសាធារណៈ',
                'content_type' => 1
            ],
            [
                'name' => 'disease prevention',
                'local_name' => 'ការការពារជំងឺ',
                'content_type' => 1
            ],
            [
                'name' => 'exercise & workouts',
                'local_name' => 'លំហាត់ប្រាណ និងលំហាត់ប្រាណ',
                'content_type' => 1
            ],
            [
                'name' => 'healthy eating',
                'local_name' => 'អាហារដែលមានសុខភាពល្អ',
                'content_type' => 1
            ],
            [
                'name' => 'healthcare tips',
                'local_name' => 'គន្លឹះថែទាំសុខភាព',
                'content_type' => 1
            ],

            // disease symptom
            ['name' => 'fever', 'local_name' => 'ក្តៅខ្លួន', 'content_type' => 2],
            ['name' => 'cough', 'local_name' => 'ក្អក', 'content_type' => 2],
            ['name' => 'sore throat', 'local_name' => 'ឈឺបំពង់ក', 'content_type' => 2],
            ['name' => 'headache', 'local_name' => 'ឈឺក្បាល', 'content_type' => 2],
            ['name' => 'shortness of breath', 'local_name' => 'ដង្ហើមខ្លី', 'content_type' => 2],
            ['name' => 'fatigue', 'local_name' => 'អស់កម្លាំង', 'content_type' => 2],
            ['name' => 'chills', 'local_name' => 'ត្រជាក់ខ្លួន', 'content_type' => 2],
            ['name' => 'muscle pain', 'local_name' => 'ឈឺសាច់ដុំ', 'content_type' => 2],
            ['name' => 'loss of taste', 'local_name' => 'បាត់រសជាតិ', 'content_type' => 2],
            ['name' => 'loss of smell', 'local_name' => 'បាត់អារម្មណ៍ការខ្ងាយ', 'content_type' => 2],
            ['name' => 'chest pain', 'local_name' => 'ឈឺបេះដូង', 'content_type' => 2],
            ['name' => 'nausea', 'local_name' => 'ចង្អោរ', 'content_type' => 2],
            ['name' => 'vomiting', 'local_name' => 'ក្អួត', 'content_type' => 2],
            ['name' => 'diarrhea', 'local_name' => 'រាក', 'content_type' => 2],
            ['name' => 'joint pain', 'local_name' => 'ឈឺដុំឆ្អឹង', 'content_type' => 2],
            ['name' => 'high blood pressure', 'local_name' => 'លើសឈាម', 'content_type' => 2],
            ['name' => 'low blood pressure', 'local_name' => 'ទាបឈាម', 'content_type' => 2],
            ['name' => 'rapid heartbeat', 'local_name' => 'បេះដូងលោតលឿន', 'content_type' => 2],
            ['name' => 'swelling', 'local_name' => 'រាកសាច់', 'content_type' => 2],
            ['name' => 'abdominal pain', 'local_name' => 'ឈឺពោះ', 'content_type' => 2],
            ['name' => 'blurred vision', 'local_name' => 'អាការៈមើលមិនច្បាស់', 'content_type' => 2],
            ['name' => 'excessive sweating', 'local_name' => 'ញើសច្រើន', 'content_type' => 2],
            ['name' => 'loss of appetite', 'local_name' => 'បាត់ឃ្លាន', 'content_type' => 2]
        ];

        foreach ($datatag as $data) {
            $tag = new Tag();
            $tag->name = $data['name'];
            $tag->local_name = $data['local_name'];
            $tag->content_type = $data['content_type'];

            $tag->save();
        }
    }
}
