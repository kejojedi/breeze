<?php

route('/cars/edit/{id}');
title('Edit Car');

$car = database('cars')->findOrFail(parameter('id'));
$rules = [
    'name' => 'required|unique:cars,name,' . $car->id,
    'year' => 'required|integer',
];

if (validate($rules)) {
    $car->update(decodes('name', 'year'));
    redirect('/cars');
}

return view(
    component('navbar') .
    container(
        headingOne('Edit Car') .
        card(
            cardBody(
                form(
                    formGroup(
                        label('Name') .
                        input('name', old('name', $car->name)) .
                        error('name')
                    ) .
                    formGroup(
                        label('Year') .
                        input('year', old('year', $car->year))->type('number') .
                        error('year')
                    ) .
                    submit('Edit Car')->buttonPrimary()
                )
            )
        )
    )->paddingVertical(4)
);
