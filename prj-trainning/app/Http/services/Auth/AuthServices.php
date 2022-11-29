<?php

namespace App\Http\services\Auth;

use App\Repositories\AuthRepositories;

class AuthServices
{
    protected $authRepositories;
    public function __construct(AuthRepositories $authRepositories)
    {
        $this->authRepositories = $authRepositories;
    }

    public function postLoginClient($request)
    {
        return $this->authRepositories->postLoginClient($request);
    }
}
