<?php

namespace App\Features\Products\QueriesHandler;

use App\Features\Products\Queries\ListProductVariantsQuery;
use App\Repository\ProductVariantRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ListProductVariantsQueryHandler
{
    private ProductVariantRepository $productVariantRepository;

    public function __construct(ProductVariantRepository $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    public function __invoke(ListProductVariantsQuery $query): array
    {
        return $this->productVariantRepository->findAllVariants($query->getLimit(), $query->getOffset());
    }
}
?>
