<?php

use App\Http\Action;

/** @var \Framework\Http\Application $app */

$app->get('home', '/', Action\IndexAction::class);
$app->get(
    'home_page',
    '/page/{page}-{sort}-{order}',
    Action\IndexAction::class,
    ['tokens' => [
        'page' => '\d+',
        'sort' => '\w+',
        'order' => '[ASC,DESC]+'
    ]]
);

$app->any('edit', '/edit/{quest}', Action\EditAction::class, ['tokens' => ['quest' => '\d+']]);
$app->any('add', '/add', Action\AddAction::class);

$app->any('login', '/login', Action\LoginAction::class);
$app->get('logout', '/logout', Action\LogoutAction::class);
