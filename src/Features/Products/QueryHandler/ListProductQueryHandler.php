<?php

namespace App\Features\Products\QueryHandler;


use App\Features\Products\Query\ListProductQuery;
use App\Repository\Products\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ListProductQueryHandler
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(ListProductQuery $query): array
    {
        return $this->productRepository->findAllProducts($query->getLimit(), $query->getOffset());
    }
}

