<?php

namespace App\Features\Products;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class ListProductsQuery
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
class ListProductsHandler
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(ListProductsQuery $query)
    {
        return $this->productRepository->findAllProducts($query->getLimit(), $query->getOffset());
    }
}
?>
