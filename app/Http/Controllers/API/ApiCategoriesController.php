<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Core\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiCategoriesController extends ApiController
{
    public function index(): JsonResponse
    {
        // Statikus JSON-t olvasunk: nincs szükség a session zárra.
        Session::close();

        $jsonPath = base_path('database/json/category-rules.json');

        if (!file_exists($jsonPath)) {
            return $this->notFound('Category rules not found.');
        }

        $jsonContent = file_get_contents($jsonPath);
        $categories = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->error('Invalid JSON format.', 500);
        }

        return $this->success($categories);
    }
}
