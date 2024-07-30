<?php

namespace App\Features\Carts;

class CreateCartItemCommand
{
    private string $cartId;
    private string $productId;
    private string $variantId;
    private string $name;
    private int $quantity;
    private float $price;
    private string $imageUrl;
    private string $description;

    private function __construct(
        string $cartId,
        string $productId,
        string $variantId,
        string $name,
        int $quantity,
        float $price,
        string $imageUrl,
        string $description
    ) {
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->variantId = $variantId;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->description = $description;
    }

    public static function create(
        string $cartId,
        string $productId,
        string $variantId,
        string $name,
        int $quantity,
        float $price,
        string $imageUrl,
        string $description
    ): self {
        return new self(
            $cartId,
            $productId,
            $variantId,
            $name,
            $quantity,
            $price,
            $imageUrl,
            $description
        );
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getVariantId(): string
    {
        return $this->variantId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
