<?php

namespace App\Features\Products\CommandHandler;

use App\Features\Products\Command\DeleteProductVariantCommand;
use App\Repository\Products\ProductVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteProductVariantCommandHandler
{
    private ProductVariantRepository $productVariantRepository;

    public function __construct(ProductVariantRepository $productVariantRepository)
    {
        $this->productVariantRepository = $productVariantRepository;
    }

    public function __invoke(DeleteProductVariantCommand $command): void
    {
        $productVariant = $this->productVariantRepository->find($command->getId());

        if (!$productVariant) {
            throw new \Exception('Product variant not found');
        }

        $this->productVariantRepository->delete($productVariant);
    }
}
?>
