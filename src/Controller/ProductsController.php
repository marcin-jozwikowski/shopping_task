<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductsController extends AbstractController
{
    public function index()
    {
        return $this->render('Products/index.html.twig');
    }

    public function products(int $page, int $per_page)
    {
        return new JsonResponse(['page' => $page, 'per_page' => $per_page, 'total_pages' => $page*5, 'products' => []]);
    }
}