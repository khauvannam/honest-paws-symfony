<?php

namespace App\Entity\Products;

use App\Repository\Products\ProductRepository;
use App\Repository\ProductVariantRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;   
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class ProductVariant
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "UUID")]
    #[ORM\Column()]
    private string $id;

    #[ORM\Column(length: 500)]
    private ?string $variantName = null;

    #[ORM\Column()]
    private ?int $quantity;

    #[ORM\Embedded(class: "App\Entity\Products\OriginalPrice")]
    private OriginalPrice $originalPrice;

    #[ORM\Column(precision: 10)]
    private ?float $discountedPrice;

    #[ORM\Column(length: 255)]
    private ?string $productId;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: "productVariants")]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id")]
    private Product $product;

    private function __construct() {}

    public static function create(string $variantName, int $quantity): ProductVariant
    {
        return new ProductVariant($variantName, $quantity);
    }

    public function update(string $variantName, OriginalPrice $originalPrice, int $quantity): void
    {
        $this->variantName = $variantName;
        $this->originalPrice = $originalPrice;
        $this->quantity = $quantity;
    }

    public function setPrice(float $value, string $currency): void
    {
        $this->originalPrice = OriginalPrice::create($value, $currency);
    }

    public function applyDiscount(float $percent): void
    {
        $this->discountedPrice = $percent == 0
            ? $this->originalPrice->getValue()
            : $this->originalPrice->getValue() - $this->originalPrice->getValue() * $percent / 100;
    }

    // Getters and setters

    public function getId(): string
    {
        return $this->id;
    }

    public function getVariantName(): string
    {
        return $this->variantName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getOriginalPrice(): OriginalPrice
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

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setVariantName(string $variantName): void
    {
        $this->variantName = $variantName;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function setOriginalPrice(OriginalPrice $originalPrice): void
    {
        $this->originalPrice = $originalPrice;
    }

    public function setDiscountedPrice(float $discountedPrice): void
    {
        $this->discountedPrice = $discountedPrice;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }   
}



