<?php

route('/cars/delete/{id}');

database('cars')->findOrFail(parameter('id'))->delete();
redirect('/cars');
