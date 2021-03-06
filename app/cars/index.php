<?php

route('/cars');
title('Cars');

$cars = database('cars')->orderBy('name')->paginate(5);

return view(
    component('navbar') .
    container(
        row(
            column(headingOne('Cars')->marginBottom(0)) .
            columnAuto(hyperlink('/cars/create', 'Create Car')->buttonPrimary())
        )->alignItemsCenter()->marginBottom(3) .
        listGroup(
            loop($cars,
                listGroupItem(
                    row(
                        column('{car.name}') .
                        columnAuto(
                            hyperlink('/cars/edit/{car.id}', icon('edit'))->marginRight(3) .
                            hyperlink('/cars/delete/{car.id}', icon('trash-alt'))->confirm('Delete this car?')
                        )
                    )
                )->paddingVertical(3)
            )
        )->marginBottom(3) .
        paginate($cars)
    )->paddingVertical(4)
);
