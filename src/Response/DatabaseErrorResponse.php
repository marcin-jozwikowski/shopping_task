<?php


namespace App\Response;


use Symfony\Component\HttpFoundation\JsonResponse;

class DatabaseErrorResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct(['error' => 'Database Error Occurred'], self::HTTP_INTERNAL_SERVER_ERROR);
    }
}