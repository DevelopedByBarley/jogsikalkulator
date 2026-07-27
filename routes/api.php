<?php

  $router->get('/api/categories', [App\Http\Controllers\API\ApiCategoriesController::class, 'index']);

  $router->get('/api/iskolak/kereses', [App\Http\Controllers\API\ApiSchoolMetricsController::class, 'search']);
  $router->get('/api/iskolak/mutatok', [App\Http\Controllers\API\ApiSchoolMetricsController::class, 'show']);

  $router->post('/api/kalkulacio/kuldes', [App\Http\Controllers\API\ApiCalculationMailController::class, 'send']);

?>