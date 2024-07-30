<?php

namespace App\Features\Products\QueriesHandler;

use App\Features\Products\Queries\ListProductsQuery;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ListProductQueryHandler
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(ListProductsQuery $query): array
    {
        return $this->productRepository->findAllProducts($query->getLimit(), $query->getOffset());
    }
}

