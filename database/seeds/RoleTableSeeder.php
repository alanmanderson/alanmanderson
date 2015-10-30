<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::unguard();
        $now = date('Y-m-d');
        Role::create(['name' => 'admin', 'created_at' => $now, 'updated_at' => $now]);
        Role::create(['name' => 'author', 'created_at' => $now, 'updated_at' => $now]);
        Role::create(['name' => 'subscriber', 'created_at' => $now, 'updated_at' => $now]);
    }
}
