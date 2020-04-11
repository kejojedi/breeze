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
                                label('Email') .
                                input('email', old('email')) .
                                error('email')
                            ) .
                            formGroup(
                                label('Password') .
                                input('password')->type('password') .
                                error('password')
                            ) .
                            checkbox('remember', 'Remember Me', old('remember'))->marginBottom(3) .
                            submit('Login')->buttonPrimary()->buttonBlock()
                        )
                    )
                )
            )->paddingVertical(4)
        )->alignItemsCenter()->justifyContentCenter()->viewHeight(100)
    )
);
