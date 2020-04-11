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
    container(
        row(
            columnDesktopFour(
                headingTwo(
                    hyperlink('/',
                        icon('wind')->textPrimary()->marginRight(2) .
                        app_title
                    )->textDark()
                )->textCenter()->marginBottom(3) .
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
                            submit('Register')->buttonPrimary()->buttonBlock()
                        )
                    )
                )
            )->paddingVertical(4)
        )->alignItemsCenter()->justifyContentCenter()->viewHeight(100)
    )
);
