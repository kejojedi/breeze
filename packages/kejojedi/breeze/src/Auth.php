<?php

namespace Kejojedi\Breeze;

class Auth
{
    public function user()
    {
        return database('users')->find($_SESSION['userId'] ?? 0);
    }

    public function check()
    {
        return isset($_SESSION['userId']);
    }

    public function attempt($credential, $password)
    {
        $user = database('users')->where('name', $credential)->orWhere('email', $credential)->first();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return null;
    }

    public function login($user)
    {
        $_SESSION['userId'] = $user->id;
    }

    public function logout()
    {
        unset($_SESSION['userId']);
    }
}
