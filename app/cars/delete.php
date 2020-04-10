<?php

route('/cars/delete/{id}');

$car = database('cars')->findOrFail(parameter('id'));
$car->delete();

redirect('/cars');
