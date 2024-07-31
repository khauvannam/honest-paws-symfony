<?php

namespace App\Features\Products\QueryHandler;

use App\Entity\Products\ProductVariant;
use App\Features\Products\Query\GetProductVariantQuery;
use App\Repository\Products\ProductVariantRepository;
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

