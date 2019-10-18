<?php 
namespace App\Repositories;

use App\Models\User;

class UserRepository {

    public function findByUsernameOrCreate($user)
    {
        return User::firstOrCreate([
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email'         => $user->email,
            'avatar'        => $user->avatar
        ]);
    }
}
