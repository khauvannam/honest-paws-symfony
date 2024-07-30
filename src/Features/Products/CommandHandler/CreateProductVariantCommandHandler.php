<?php

namespace App\Features\Products\CommandHandler;

use App\Entity\Products\OriginalPrice;
use App\Entity\Products\ProductVariant;
use App\Features\Products\Command\CreateProductVariantCommand;
use App\Repository\ProductVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateProductVariantCommandHandler
{
    private EntityManagerInterface $entityManager;
    private ProductVariantRepository $productVariantRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductVariantRepository $productVariantRepository)
    {
        $this->entityManager = $entityManager;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function __invoke(CreateProductVariantCommand $command): void
    {
        // Check if the product variant exists
        $productVariant = $this->productVariantRepository->findOneBy([
            'product' => $command->getProduct(),
            'variantName' => $command->getVariantName()
        ]);

        $originalPrice = OriginalPrice::create($command->getOriginalPrice());
        if ($productVariant) {
            // Update existing product variant
            $productVariant->setQuantity($command->getQuantity());
            $productVariant->setOriginalPrice($originalPrice);
            $productVariant->setDiscountedPrice($command->getDiscountedPrice());
        } else {
            // Create new product variant
            $productVariant = ProductVariant::create($command->getVariantName(), $command->getQuantity());
            $productVariant->setVariantName($command->getVariantName());
            $productVariant->setQuantity($command->getQuantity());
            $productVariant->setOriginalPrice($originalPrice);
            $productVariant->setDiscountedPrice($command->getDiscountedPrice());
            $productVariant->setProduct($command->getProduct());
        }

        $this->productVariantRepository->save($productVariant);
    }
}
?>
