<?php
namespace App\Features\Products\CommandHandler;

use App\Entity\Products\Product;
use App\Features\Products\Command\CreateProductCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Products\ProductRepository;

class CreateProductCommandHandler implements CommandHandlerInterface 
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
