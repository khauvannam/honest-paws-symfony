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
        $products = $this->productRepository->findAllProducts(4);
        $categories = $this->categoryRepository->findAllCategory(limit: 6);
        return ['products' => $products, 'categories' => $categories];
    }

}