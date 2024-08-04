<?php

namespace App\Features\Products\CommandHandler;

use App\Features\Products\Command\UpdateProductCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Products\ProductRepository;
use App\Services\BlobService;
use Exception;

class UpdateProductCommandHandler implements CommandHandlerInterface
{
    private ProductRepository $productRepository;
    private BlobService $blobService;

    public function __construct(ProductRepository $productRepository, BlobService $blobService)
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

        $fileName = $this->blobService->upload($command->getImageFile());

        if ($product->getImageUrl() !== $fileName && $command->getImageFile() !== null) {
            $product->setImageUrl($fileName);
        }
        $product->setName($command->getName());
        $product->setDescription($command->getDescription());
        $product->setProductUseGuide($command->getProductUseGuide());
        $product->setDiscountPercent($command->getDiscountPercent());
        $product->setUpdatedAt($command->getUpdatedAt());

        $this->productRepository->update($product);
    }
}

?>
