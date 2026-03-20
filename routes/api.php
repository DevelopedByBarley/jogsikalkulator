<?php

  $router->get('/api/categories', [App\Http\Controllers\API\ApiCategoriesController::class, 'index']);

?>