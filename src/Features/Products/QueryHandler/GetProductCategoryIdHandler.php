<?php

namespace App\Features\Products\QueryHandler;

use App\Entity\Products\Product;
use App\Features\Products\Query\GetProductByCategoryIDQuery;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


#[AsMessageHandler]
class GetProductByCategoryIDQueryHandler 
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(GetProductByCategoryIDQuery $query): array
    {
        return $this->productRepository->findByCategoryId($query->getCategoryId());
    }
}
