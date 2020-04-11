<?php

route('/auth/register');
title('Register');

$rules = [
    'name' => 'required',
    'email' => 'required|email|unique:users',
    'password' => 'required|confirmed',
];

if (validate($rules)) {
    $user = database('users')->create([
        'name' => decode('name'),
        'email' => decode('email'),
        'password' => passwordHash(decode('password')),
    ]);
    authLogin($user);
    redirect('/');
}

return view(
    component('navbar') .
    container(
        heading('Register') .
        card(
            cardBody(
                form(
                    formGroup(
                        label('Name') .
                        input('name', old('name')) .
                        error('name')
                    ) .
                    formGroup(
                        label('Email') .
                        input('email', old('email'))->type('email') .
                        error('email')
                    ) .
                    formGroup(
                        label('Password') .
                        input('password')->type('password') .
                        error('password')
                    ) .
                    formGroup(
                        label('Confirm Password') .
                        input('password_confirmation')->type('password')
                    ) .
                    submit('Register')->buttonPrimary()
                )
            )
        )
    )->marginVertical(4)
);
