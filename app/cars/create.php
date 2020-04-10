<?php

route('/cars/create');
title('Create Car');

$rules = [
    'name' => 'required|unique:cars',
    'year' => 'required|integer',
];

if (validate($rules)) {
    database('cars')->create(formData('name', 'year'));
    redirect('/cars');
}

return view(
    component('navbar') .
    container(
        heading('Create Car') .
        card(
            cardBody(
                form(
                    formGroup(label('Name') . input('name') . error('name')) .
                    formGroup(label('Year') . input('year')->type('number') . error('year')) .
                    submit('Create Car')->buttonPrimary()
                )
            )
        )
    )->marginVertical(4)
);
