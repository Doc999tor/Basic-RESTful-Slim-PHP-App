<?php

$app->get('/', 'UsersController:home');

$app->get('/users', 'UsersController:showUsers');

$app->get('/api/users', 'UsersController:get');
$app->post('/api/user', 'UsersController:post');

$app->group('/api/user/{id:\d+}', function () {
	$this->put   ('', 'UsersController:put');
	$this->patch ('', 'UsersController:patch');
	$this->delete('', 'UsersController:delete');
});

$app->options('/', 'UsersController:options');