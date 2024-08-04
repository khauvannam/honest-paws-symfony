<?php

namespace App\Features\Products\CommandHandler;

use App\Features\Products\Command\DeleteProductCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Products\ProductRepository;
use App\Services\BlobService;

class DeleteProductCommandHandler implements CommandHandlerInterface
{
    private ProductRepository $productRepository;
    private BlobService $blobService;

    public function __construct(ProductRepository $productRepository, BlobService $blobService)
    {
        $this->productRepository = $productRepository;
        $this->blobService = $blobService;
    }

    /**
     * @throws \Exception
     */
    public function __invoke(DeleteProductCommand $command): void
    {
        $product = $this->productRepository->find($command->getId());

        if (!$product) {
            throw new \Exception('Product not found');
        }
        $this->blobService->delete($product->getImageUrl());

        $this->productRepository->delete($product);
    }
}


