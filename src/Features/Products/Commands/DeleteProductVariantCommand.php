<?php

namespace App\Features\Products\Commands;

use App\Repository\ProductVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class DeleteProductVariantCommand
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
class DeleteProductVariantCommandHandler
{

    private ProductVariantRepository $productVariantRepository;

    public function __construct(ProductVariantRepository $productVariantRepository)
    {

        $this->productVariantRepository = $productVariantRepository;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(DeleteProductVariantCommand $command): void
    {
        $productVariant = $this->productVariantRepository->find($command->getId());

        if (!$productVariant) {
            throw new \Exception('Product variant not found');
        }
        $this->productVariantRepository->delete($productVariant);
    }
}

