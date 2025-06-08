<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataCate = [
            // article tag
            ['name' => 'general', 'local_name' => 'ចំណេះដឹងទូទៅ', 'content_type' => 1],
            ['name' => 'health check', 'local_name' => 'ពិនិត្យសុខភាព', 'content_type' => 1],
            ['name' => 'surgery', 'local_name' => 'ការវះកាត់', 'content_type' => 1],


            // disease tag
            ['name' => 'infectious diseases ', 'local_name' => 'ជំងឺឆ្លង', 'content_type' => 2],
            [
                'name' => 'sporadic diseases',
                'local_name' => 'ជំងឺជាករណី',
                'content_type' => 2,
            ],
            [
                'name' => 'endemic diseases',
                'local_name' => 'ជំងឺបរិស្ថាន',
                'content_type' => 2,
            ],
            [
                'name' => 'foodborne diseases',
                'local_name' => 'ជំងឺផ្ទុកអាហារ',
                'content_type' => 2,
            ],
        ];

        foreach ($dataCate as $data) {
            $cat = new Category();
            $cat->name = $data['name'];
            $cat->local_name = $data['local_name'];
            $cat->content_type = $data['content_type'];
            $cat->save();
        }
    }
}
