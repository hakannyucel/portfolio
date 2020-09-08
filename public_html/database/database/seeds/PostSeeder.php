<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'title' => 'PHP Kodlama',
            'content' => '<p>Laravel ile php kodlama.</p>',
            'slug' => 'php-kodlama',
            'category_id' => 1,
            'keywords' => 'deneme, her sey',
            'image' => 'uploads/php-kodlama.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
