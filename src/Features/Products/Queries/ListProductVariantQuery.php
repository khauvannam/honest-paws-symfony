<?php

namespace App\Features\Products\Queries;

use App\Repository\ProductVariantRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class ListProductVariantsQuery
{
    private int $limit;
    private int $offset;

    public function __construct(int $limit, int $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public static function create(int $limit, int $offset): self
    {
        return new self($limit, $offset);
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}

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

