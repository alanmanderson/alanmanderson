<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::unguard();
        User::create(['first_name' => 'Alan', 'last_name' => 'Anderson', 'email' => 'test@test.com', 'role_id' => 1]);
    }
}
