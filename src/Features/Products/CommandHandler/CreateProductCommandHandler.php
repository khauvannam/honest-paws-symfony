<?php
namespace App\Features\Products\CommandHandler;

use App\Entity\Products\Product;
use App\Features\Products\Command\CreateProductCommand;
use App\Repository\Products\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateProductCommandHandler
{
    private ProductRepository $productRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
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
            $command->getUpdatedAt(),
            $command->getProductVariants()->toArray()
        );

        $this->productRepository->save($product);
    }
}
?>
