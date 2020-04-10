<?php

route('/cars');
title('Cars');

$cars = database('cars')->orderBy('name')->paginate(5);

return view(
    component('navbar') .
    container(
        row(
            column(heading('Cars')) .
            column(hyperlink('/cars/create', 'Create Car'), 'auto')
        ) .
        loop(
            $cars,
            div('{car.name}') .
            hyperlink('/cars/edit/{car.id}', 'Edit') .
            horizontalRule()
        ) .
        paginate($cars)
    )->marginVertical(4)
);
