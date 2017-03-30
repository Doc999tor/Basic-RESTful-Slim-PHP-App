<?php

$app->get('/', 'UsersController:home');

$app->get('/users', 'UsersController:showUsers');

$app->get('/api/users', 'UsersController:get');
$app->post('/api/user', 'UsersController:post');
$app->put('/api/user/{id:\d+}', 'UsersController:put');
$app->patch('/api/user/{id:\d+}', 'UsersController:patch');
$app->delete('/api/user', 'UsersController:delete');
$app->options('/', 'UsersController:options');