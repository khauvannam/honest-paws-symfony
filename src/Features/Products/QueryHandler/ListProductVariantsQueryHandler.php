<?php

namespace App\Features\Products\QueryHandler;

use App\Features\Products\Query\ListProductVariantQuery;
use App\Repository\Products\ProductVariantRepository;
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

