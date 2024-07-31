<?php
namespace App\Features\Products\CommandHandler;

use App\Entity\Products\Product;
use App\Features\Products\Command\CreateProductCommand;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateProductCommandHandler
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $product = Product::create(
            $command->getName(),
            $command->getDescription(),
            $command->getProductUseGuide(),
            $command->getImageUrl(),
            $command->getDiscountPercent(),
            $command->getCreatedAt(),
            $command->getUpdatedAt()
        );

        $this->productRepository->save($product);
    }
}
