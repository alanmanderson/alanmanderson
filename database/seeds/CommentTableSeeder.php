<?php

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::unguard();
        $now = date('Y-m-d');
        Comment::create(['post_id' => 1, 'user_id' => 1, 'body' => 'First Comment', 'created_at' => $now, 'updated_at' => $now]);
    }
}
