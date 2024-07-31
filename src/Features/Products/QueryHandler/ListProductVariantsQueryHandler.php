<?php

namespace App\Features\Products\QueryHandler;

<<<<<<< HEAD:src/Features/Products/QueriesHandler/ListProductVariantQueryHandler.php
use App\Features\Products\Queries\ListProductVariantQuery;
use App\Repository\ProductVariantRepository;
=======
use App\Features\Products\Query\ListProductVariantQuery;
use App\Repository\Products\ProductVariantRepository;
>>>>>>> origin/namdeptrai:src/Features/Products/QueryHandler/ListProductVariantsQueryHandler.php
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ListProductVariantsQueryHandler
{
    private ProductVariantRepository $productVariantRepository;

    public function __construct(ProductVariantRepository $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    public function __invoke(ListProductVariantQuery $query): array
    {
        return $this->productVariantRepository->findAllVariants($query->getLimit(), $query->getOffset());
    }
}

