<?php

namespace App\Features\Products\QueriesHandler;

use App\Repository\ProductVariantRepository;
use App\Entity\Products\ProductVariant;
use App\Features\Products\Queries\GetProductVariantQuery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetProductVariantQueryHandler
{
    private ProductVariantRepository $productVariantRepository;

    public function __construct(ProductVariantRepository $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    public function __invoke(GetProductVariantQuery $query): ?ProductVariant
    {
        return $this->productVariantRepository->find($query->getId());
    }
}

