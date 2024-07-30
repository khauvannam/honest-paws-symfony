<?php

namespace App\Features\Products\Command;

use App\Entity\Products\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
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
