<?php

namespace App\Features\Products\QueryHandler;

<<<<<<< HEAD:src/Features/Products/QueriesHandler/ListProductQueryHandler.php
use App\Features\Products\Queries\ListProductQuery;
=======
use App\Features\Products\Query\ListProductQuery;
>>>>>>> origin/namdeptrai:src/Features/Products/QueryHandler/ListProductQueryHandler.php
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

    public function __invoke(ListProductQuery $query): array
    {
        return $this->productRepository->findAllProducts(
            $query->getLimit(),
            $query->getOffset()
        );
    }
}
