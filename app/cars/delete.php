<?php

route('/cars/delete/{id}');

$car = database('cars')->findOrFail(param('id'));
$car->delete();

redirect('/cars');
