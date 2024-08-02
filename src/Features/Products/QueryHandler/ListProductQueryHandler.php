<?php

namespace App\Features\Products\QueryHandler;

use App\Features\Products\Query\ListProductQuery;
use App\Interfaces\QueryHandlerInterface;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class ListProductQueryHandler implements QueryHandlerInterface
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(ListProductQuery $query): array
    {
        return $this->productRepository->findAllProducts(
            $query->getLimit(),
            $query->getOffset()
        );
    }
}