<?php

namespace App\Features\Products;

use App\Entity\Products\OriginalPrice;
use App\Entity\Products\Product;
use App\Entity\Products\ProductVariant;
use App\Repository\ProductVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProductVariantCommand
{
    private string $variantName;
    private int $quantity;
    private float $originalPrice;
    private float $discountedPrice;
    private string $productId;
    private Product $product;

    public function __construct(string $variantName, int $quantity, float $originalPrice, float $discountedPrice, string $productId, Product $product)
    {
        $this->variantName = $variantName;
        $this->quantity = $quantity;
        $this->originalPrice = $originalPrice;
        $this->discountedPrice = $discountedPrice;
        $this->productId = $productId;
        $this->product = $product;
    }

    public static function create(string $variantName, int $quantity, float $originalPrice, float $discountedPrice, string $productId, Product $product): self
    {
        return new self($variantName, $quantity, $originalPrice, $discountedPrice, $productId, $product);
    }

    public function getVariantName(): string
    {
        return $this->variantName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getOriginalPrice(): float
    {
        return $this->originalPrice;
    }

    public function getDiscountedPrice(): float
    {
        return $this->discountedPrice;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}

#[AsMessageHandler]
class CreateProductVariantCommandHandler
{
    private EntityManagerInterface $entityManager;
    private ProductVariantRepository $productVariantRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductVariantRepository $productVariantRepository)
    {
        $this->entityManager = $entityManager;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function __invoke(CreateProductVariantCommand $command): void
    {
        // Check if the product variant exists
        $productVariant = $this->productVariantRepository->findOneBy([
            'product' => $command->getProduct(),
            'variantName' => $command->getVariantName()
        ]);

        if ($productVariant) {
            $originalPrice = OriginalPrice::create($command->getOriginalPrice());
            // Update existing product variant
            $productVariant->setQuantity($command->getQuantity());
            $productVariant->setOriginalPrice($originalPrice);
            $productVariant->setDiscountedPrice($command->getDiscountedPrice());
        } else {
            $originalPrice = OriginalPrice::create($command->getOriginalPrice());
            // Create new product variant
            $productVariant = new ProductVariant();
            $productVariant->setVariantName($command->getVariantName());
            $productVariant->setQuantity($command->getQuantity());
            $productVariant->setOriginalPrice($originalPrice);
            $productVariant->setDiscountedPrice($command->getDiscountedPrice());
            $productVariant->setProduct($command->getProduct());
            $this->entityManager->persist($productVariant);
        }

        $this->entityManager->flush();
    }
}

class CreateProductVariantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('variantName', TextType::class, [
                'label' => 'Variant Name',
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Quantity',
            ])
            ->add('originalPrice', NumberType::class, [
                'label' => 'Original Price',
            ])
            ->add('discountedPrice', NumberType::class, [
                'label' => 'Discounted Price',
            ])
            ->add('productId', TextType::class, [
                'label' => 'Product ID',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateProductVariantCommand::class,
        ]);
    }
}
