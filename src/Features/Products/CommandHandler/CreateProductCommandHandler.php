<?php

namespace App\Features\Products\CommandHandler;

use App\Entity\Products\Product;
use App\Features\Products\Command\CreateProductCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Products\ProductRepository;
use App\Services\BlobService;

class CreateProductCommandHandler implements CommandHandlerInterface
{
    private ProductRepository $productRepository;
    private BlobService $blobService;

    public function __construct(ProductRepository $productRepository, BlobService $blobService)

    {
        $this->productRepository = $productRepository;
        $this->blobService = $blobService;
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $fileName = $this->blobService->upload($command->getImageFile());
        $product = Product::create(
            $command->getName(),
            $command->getDescription(),
            $command->getProductUseGuide(),
            $fileName,
            $command->getDiscountPercent(),
            $command->getCreatedAt(),
            $command->getUpdatedAt()
        );

        $this->productRepository->save($product);
    }
}
