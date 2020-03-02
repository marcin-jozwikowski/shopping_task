<?php


namespace App\Response;


use Symfony\Component\HttpFoundation\Response;

class CouldNotSaveResponse extends Response
{
    public function __construct()
    {
        parent::__construct("Could not save", self::HTTP_INTERNAL_SERVER_ERROR, []);
    }
}