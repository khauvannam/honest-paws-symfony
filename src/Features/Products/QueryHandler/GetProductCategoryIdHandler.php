<?php

namespace App\Features\Products\QueryHandler;

use App\Features\Products\Query\GetProductCategoryId;
use App\Repository\Categories\CategoryRepository;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler]
class GetProductCategoryIdHandler 
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository, private readonly CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(GetProductCategoryId $query): array
    {
        $products =  $this->productRepository->findByCategoryId($query->getCategoryId());
        $categories = $this->categoryRepository->findAllCategory(10);
        return ['products' =>$products,'categories' => $categories]; 
    }
}
