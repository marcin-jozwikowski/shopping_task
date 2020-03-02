<?php


namespace App\DataProvider;


use App\Repository\ProductRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class ProductDataProvider
{
    const MAX_PER_PAGE = 25;
    const MIN_PER_PAGE = 5;

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getProductData(int $page, int $perPage): array
    {
        $perPage    = min(self::MAX_PER_PAGE, max(self::MIN_PER_PAGE, $perPage));
        $totalPages = $this->getTotalPages($perPage);
        $page       = min($totalPages, max(1, $page));
        return [
            'page'        => $page,
            'per_page'    => $perPage,
            'total_pages' => $totalPages,
            'products'    => $this->getProductsPage($page, $perPage)
        ];
    }

    /**
     * @param int $perPage
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    private function getTotalPages(int $perPage): int
    {
        $count = $this->productRepository->getProductCount();
        return ceil($count / $perPage);
    }

    private function getProductsPage(int $page, int $perPage): array
    {
        return $this->productRepository->getProductPageData($page, $perPage);
    }
}