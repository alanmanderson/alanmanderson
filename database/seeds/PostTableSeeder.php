<?php

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::unguard();
        $now = date('Y-m-d');
        Post::create(['author_id' => 1, 'title' => 'First Blog', 'body' => '**First** Blog Body', "slug" => ";lknqwer897afd", "active" => 1, "created_at" => $now, "updated_at" => $now]);
    }
}
