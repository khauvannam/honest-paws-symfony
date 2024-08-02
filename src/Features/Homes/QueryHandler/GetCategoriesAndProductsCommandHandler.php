<?php

namespace App\Features\Homes\QueryHandler;

use App\Features\Homes\Query\GetCategoriesAndProductCommands;
use App\Interfaces\QueryHandlerInterface;
use App\Repository\Categories\CategoryRepository;
use App\Repository\Products\ProductRepository;

class GetCategoriesAndProductsCommandHandler implements QueryHandlerInterface
{

    public function __construct(private CategoryRepository $categoryRepository, private ProductRepository $productRepository)
    {
    }

    public function __invoke(GetCategoriesAndProductCommands $commands): array
    {
        $products = $this->productRepository->findAllProducts(4);
        $categories = $this->categoryRepository->findAllCategory(limit: 6);
        return ['products' => $products, 'categories' => $categories];
    }

}