<?php

namespace App\Features\Products\CommandHandler;

use App\Features\Products\Command\DeleteProductCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Interfaces\QueryHandlerInterface;
use App\Repository\Products\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class DeleteProductCommandHandler implements CommandHandlerInterface
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(DeleteProductCommand $command): void
    {
        $product = $this->productRepository->find($command->getId());

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $this->productRepository->delete($product);
    }
}
?>
