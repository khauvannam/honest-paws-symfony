<?php

namespace App\Features\Products\Queries;

use App\Entity\Products\Product;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class GetProductQuery
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

#[AsMessageHandler]
class GetProductQueryHandler
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

