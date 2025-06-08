<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleTagSeeder extends Seeder
{

    public function run(): void
    {
        $tagIds = range(14, 36);
        $articleIds = range(1, 26);

        foreach ($articleIds as $articleId) {
            $selectedTags = collect($tagIds)->shuffle()->take(rand(1, 5));
            foreach ($selectedTags as $tagId) {
                DB::table('article_tag')->insert([
                    'article_id' => $articleId,
                    'tag_id' => $tagId,
                ]);
            }
        }
    }
}
