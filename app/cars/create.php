<?php

route('/cars/create');
title('Create Car');

$rules = [
    'name' => 'required|unique:cars',
    'year' => 'required|integer',
];

if (validate($rules)) {
    database('cars')->create([
        'name' => data('name'),
        'year' => data('year'),
    ]);
    redirect('/cars');
}

return view(
    component('navbar') .
    container(
        heading('Create Car') .
        form(
            formGroup(label('Name') . input('name') . error('name')) .
            formGroup(label('Year') . input('year')->type('number') . error('year')) .
            submit('Create Car')
        )
    )->marginVertical(4)
);
