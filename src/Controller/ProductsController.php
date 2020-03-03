<?php


namespace App\Controller;


use App\DataProvider\ProductDataProvider;
use App\Entity\Product;
use App\Form\ProductType;
use App\Message\ProductAddedMessage;
use App\Repository\ProductRepository;
use App\Response\CouldNotSaveResponse;
use App\Response\DatabaseErrorResponse;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function add(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $productRepository->save($product);
                $this->dispatchMessage(new ProductAddedMessage($this->getUser(), $product));
            } catch (OptimisticLockException $e) {
                return new CouldNotSaveResponse();
            } catch (ORMException $e) {
                return new CouldNotSaveResponse();
            }

            return $this->redirectToRoute('index');
        }

        return $this->render('Products/add.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

}