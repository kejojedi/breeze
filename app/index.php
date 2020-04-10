<?php

route('/');
title('Index');

return view(
    component('navbar') .
    container(
        paragraph('Welcome to the Breeze demo!')
    )->marginVertical(4)
);
