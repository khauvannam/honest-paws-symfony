<?php

namespace App\Features\Products\CommandHandler;

use App\Entity\Products\Product;
use App\Features\Products\Command\CreateProductCommand;
use App\Repository\Products\ProductRepository;
use App\Services\BlobService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateProductCommandHandler
{
    private ProductRepository $productRepository;
    private BlobService $blobService;

    public function __construct(
        ProductRepository $productRepository,
        BlobService       $blobService
    )
    {
        $this->productRepository = $productRepository;
        $this->blobService = $blobService;
    }

    public function __invoke(CreateProductCommand $command): void
    {
        $fileName = $this->blobService->upload($command->getImgFile());
        $product = Product::create(
            $command->getName(),
            $command->getPrice(),
            $command->getDescription(),
            $command->getProductUseGuide(),
            $fileName,
            $command->getDiscountPercent(),
            $command->getCategoryId(),
        );

        $this->productRepository->save($product);
    }
}
