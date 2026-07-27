<?php

declare(strict_types=1);

$router->get('/admin/iskola-mutatok', [\App\Http\Controllers\Admin\SchoolMetricsController::class, 'index'])
    ->name('admin.school-metrics')->middleware('admin');

$router->get('/admin/iskola-mutatok/bongeszes', [\App\Http\Controllers\Admin\SchoolMetricsController::class, 'browse'])
    ->name('admin.school-metrics.browse')->middleware('admin');

$router->post('/admin/iskola-mutatok/elonezet', [\App\Http\Controllers\Admin\SchoolMetricsController::class, 'preview'])
    ->name('admin.school-metrics.preview')->middleware('admin');

$router->post('/admin/iskola-mutatok', [\App\Http\Controllers\Admin\SchoolMetricsController::class, 'store'])
    ->name('admin.school-metrics.store')->middleware('admin');
