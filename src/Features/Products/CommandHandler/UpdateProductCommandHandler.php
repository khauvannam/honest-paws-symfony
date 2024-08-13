<?php

namespace App\Features\Products\CommandHandler;

use App\Features\Products\Command\UpdateProductCommand;
use App\Repository\Products\ProductRepository;
use App\Services\BlobService;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateProductCommandHandler
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

    /**
     * @throws Exception
     */
    public function __invoke(UpdateProductCommand $command): void
    {
        $product = $this->productRepository->find($command->getId());

        if (!$product) {
            throw new Exception("Product not found");
        }

        if ($command->getImageFile() !== null) {
            $fileName = $this->blobService->upload($command->getImageFile());
            $this->blobService->delete($product->getImageUrl());
            $product->setImageUrl($fileName);
        }

        $product->update(
            $command->getName(),
            $command->getQuantity(),
            $command->getDescription(),
            $command->getProductUseGuide(),
            $command->getDiscountPercent(),
            $command->getPrice()
        );

        $this->productRepository->update($product);
    }
}

?>
