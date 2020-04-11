<?php

route('/auth/login');
title('Login');

$rules = [
    'email' => 'required|email',
    'password' => 'required',
];

if (validate($rules) && $user = authAttempt('email', 'password')) {
    authLogin($user);
    redirect('/');
}

return view(
    component('navbar') .
    container(
        heading('Login') .
        card(
            cardBody(
                form(
                    formGroup(
                        label('Email') .
                        input('email', old('email')) .
                        error('email')
                    ) .
                    formGroup(
                        label('Password') .
                        input('password')->type('password') .
                        error('password')
                    ) .
                    submit('Login')->buttonPrimary()
                )
            )
        )
    )->marginVertical(4)
);
