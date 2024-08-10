<?php

namespace App\Features\Homes\QueryHandler;

use App\Features\Homes\Query\GetCategoriesAndProductsQuery;
use App\Repository\Categories\CategoryRepository;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetCategoriesAndProductsQueryHandler
{
    public function __construct(private CategoryRepository $categoryRepository, private ProductRepository $productRepository)
    {
    }

    public function __invoke(GetCategoriesAndProductsQuery $commands): array
    {
        $products = $this->productRepository->findAllProducts($commands->getProductLimit(), 0, $commands->getText());
        $categories = $this->categoryRepository->findAllCategory($commands->getCategoryLimit());
        return ['products' => $products, 'categories' => $categories];
    }

}