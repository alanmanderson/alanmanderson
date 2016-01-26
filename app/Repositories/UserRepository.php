<?php namespace App\Repositories;

use App\Models\User;

class UserRepository {
    public function findByUsernameOrCreate($userData)
    {
        return User::firstOrCreate([
            'first_name'    => $userData->name,
            'email'         => $userData->email,
            'avatar'        => $userData->avatar
        ]);
    }
}
