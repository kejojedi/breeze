<?php

route('/cars/edit/{id}');
title('Edit Car');

$car = database('cars')->findOrFail(parameter('id'));
$rules = [
    'name' => 'required|unique:cars,name,' . $car->id,
    'year' => 'required|integer',
];

if (validate($rules)) {
    $car->update(formData('name', 'year'));
    redirect('/cars');
}

return view(
    component('navbar') .
    container(
        heading('Edit Car') .
        card(
            cardBody(
                form(
                    formGroup(label('Name') . input('name', $car->name) . error('name')) .
                    formGroup(label('Year') . input('year', $car->year)->type('number') . error('name')) .
                    submit('Edit Car')->buttonPrimary()
                )
            )
        )
    )->marginVertical(4)
);
