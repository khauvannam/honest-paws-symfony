<?php

namespace App\Features\Products\Commands;

use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class DeleteProductCommand
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function create(int $id): self
    {
        return new self($id);
    }

    public function getId(): int
    {
        return $this->id;
    }
}

#[AsMessageHandler]
class DeleteProductCommandHandler
{
    private ProductRepository $productRepository;


    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $product = $this->productRepository->find($command->getId());

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $this->productRepository->deleteProduct($product);
    }
}


