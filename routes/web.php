<?php

$router = router();

$router->getNativeRouter()->aliasMiddleware(
    'admin',
    \App\Http\Middlewares\AdminMiddleware::class
);

$router->get('/', [App\Http\Controllers\HomeController::class, 'index']);
$router->post('/test', [App\Http\Controllers\HomeController::class, 'store']);

$router->get('/lang/{lang}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');

$router->get('/rolunk', fn() => page('pages/about', ['title' => 'Rólunk', 'navigation' => ['previous' => [
    'name' => null,
    'url' => null
], 'next' => [
    'name' => 'Alapkövetelmények',
    'url' => '/alapkovetelmenyek'
]]]));


$router->get('/alapkovetelmenyek', fn() => page('pages/requirements', ['title' => 'Alapkövetelmények', 'navigation' => ['previous' => [
    'name' => 'Rólunk',
    'url' => '/rolunk'
], 'next' => [
    'name' => 'Képzés menete',
    'url' => '/kepzes-menete'
]]]));


$router->get('/kepzes-menete', fn() => page('pages/training', ['title' => 'Képzés menete', 'navigation' => ['previous' => [
    'name' => 'Alapkövetelmények',
    'url' => '/alapkovetelmenyek'
], 'next' => [
    'name' => 'Hasznos tippek',
    'url' => '/hasznos-tippek'
]]]));


$router->get('/hasznos-tippek', fn() => page('pages/tips', ['title' => 'Hasznos tippek', 'navigation' => ['previous' => [
    'name' => 'Képzés menete',
    'url' => '/kepzes-menete'
], 'next' => [
    'name' => null,
    'url' => null
]]]));


$router->get('/iskolavalasztas', fn() => page('pages/school-selection', ['title' => 'Iskolaválasztás', 'navigation' => ['previous' => [
    'name' => 'Jogsikalkulátor',
    'url' => '/'
], 'next' => [
    'name' => null,
    'url' => null
]]]));


require __DIR__ . '/posts.php';
require __DIR__ . '/admin/auth.php';
require __DIR__ . '/admin/settings.php';
require __DIR__ . '/admin/dashboard.php';

require __DIR__ . '/user/auth.php';
require __DIR__ . '/api.php';

$router->run();
