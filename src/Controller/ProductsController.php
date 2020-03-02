<?php


namespace App\Controller;


use App\DataProvider\ProductDataProvider;
use App\Response\DatabaseErrorResponse;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductsController extends AbstractController
{
    public function index()
    {
        return $this->render('Products/index.html.twig');
    }

    public function products(int $page, int $per_page, ProductDataProvider $dataProvider)
    {
        try {
            $data = $dataProvider->getProductData($page, $per_page);
        } catch (NoResultException $e) {
            return new DatabaseErrorResponse();
        } catch (NonUniqueResultException $e) {
            return new DatabaseErrorResponse();
        }
        return new JsonResponse($data);
    }
}