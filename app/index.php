<?php

route('/');
title('Index');

return view(
    component('navbar') .
    container(
        paragraph('Welcome to the Breeze demo!') .
        paragraph(
            authGuest()
                ? 'You are not logged in.'
                : 'You are logged in as ' . authUser()->name . '.'
        )
    )->marginVertical(4)
);
