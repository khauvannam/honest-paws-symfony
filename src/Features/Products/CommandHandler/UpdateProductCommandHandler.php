<?php

namespace App\Features\Products\CommandHandler;

use App\Features\Products\Command\UpdateProductCommand;
use App\Repository\Products\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateProductCommandHandler
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

    }

    /**
     * @throws Exception
     */
    public function __invoke(UpdateProductCommand $command): void
    {
        $product = $this->productRepository->find($command->getId());

        if (!$product) {
            throw new Exception('Product not found');
        }

        $product->setName($command->getName());
        $product->setDescription($command->getDescription());
        $product->setProductUseGuide($command->getProductUseGuide());
        $product->setImageUrl($command->getImageUrl());
        $product->setDiscountPercent($command->getDiscountPercent());
        $product->setUpdatedAt($command->getUpdatedAt());

        $this->productRepository->update($product);
    }
}
?>
