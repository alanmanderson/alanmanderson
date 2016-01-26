<?php namespace App;

use App\Repositories\UserRepository;
use App\Listeners\AuthenticateUserListener;
use Illuminate\Contracts\Auth\Guard as Authenticator;
use Laravel\Socialite\Contracts\Factory as Socialite;


class AuthenticateUser {

    private $users;
    private $socialite;
    private $auth;

    public function __construct(UserRepository $users, Socialite $socialite, Authenticator $auth)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;

    }

    public function execute($hasCode, AuthenticateUserListener $listener)
    {
        if (! $hasCode) return $this->getAuthorizationFirst();

        $user = $this->users->findByUsernameOrCreate($this->getGithubUser());

        $this->auth->login($user, true);

        return $listener->userHasLoggedIn($user);
    }

    public function getAuthorizationFirst()
    {
        return $this->socialite->driver('github')->redirect();
    }

    public function getGithubUser()
    {
        //dd($this->socialite->driver('github')->user());
        return $this->socialite->driver('github')->user();
    }

}
