<?php

namespace App\Features\Products\QueryHandler;

use App\Entity\Products\Product;
use App\Features\Products\Query\GetProductQuery;
use App\Interfaces\QueryHandlerInterface;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class GetProductQueryHandler implements QueryHandlerInterface
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(GetProductQuery $query): ?Product
    {
        return $this->productRepository->find($query->getId());
    }
}
