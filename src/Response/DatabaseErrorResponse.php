<?php


namespace App\Response;


use Symfony\Component\HttpFoundation\JsonResponse;

class DatabaseErrorResponse extends JsonResponse
{
    public function __construct($data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct(['error' => 'Database Error Occurred'], self::HTTP_INTERNAL_SERVER_ERROR);
    }
}