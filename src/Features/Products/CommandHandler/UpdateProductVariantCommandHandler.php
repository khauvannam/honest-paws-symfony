<?php

namespace App\Features\Products\CommandHandler;

use App\Entity\Products\OriginalPrice;
use App\Features\Products\Command\UpdateProductVariantCommand;
use App\Repository\ProductVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateProductVariantCommandHandler
{
    private EntityManagerInterface $entityManager;
    private ProductVariantRepository $productVariantRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductVariantRepository $productVariantRepository)
    {
        $this->entityManager = $entityManager;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function __invoke(UpdateProductVariantCommand $command): void
    {
        $productVariant = $this->productVariantRepository->find($command->getId());

        if (!$productVariant) {
            throw new \Exception('Product variant not found');
        }

        $originalPrice = OriginalPrice::create($command->getOriginalPrice());

        $productVariant->setVariantName($command->getVariantName());
        $productVariant->setQuantity($command->getQuantity());
        $productVariant->setOriginalPrice($originalPrice);
        $productVariant->setDiscountedPrice($command->getDiscountedPrice());

        $this->productVariantRepository->update($productVariant);
    }
}
?>
