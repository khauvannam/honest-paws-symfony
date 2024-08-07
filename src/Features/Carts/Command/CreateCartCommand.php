<?php

namespace App\Features\Carts\Command;

class CreateCartCommand
{
    private string $customerId;
    private string $productId;
    private string $name;
    private int $quantity;
    private float $price;
    private ?string $imageUrl;
    private ?string $description;

    private function __construct(string $customerId, string $productId, string $name, int $quantity, float $price, ?string $imageUrl = null, ?string $description = null)
    {
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->description = $description;
    }

    public static function create(string $customerId, string $productId, string $name, int $quantity, float $price, ?string $imageUrl = null, ?string $description = null): self
    {
        return new self($customerId, $productId, $name, $quantity, $price, $imageUrl, $description);
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getProductId(): string
    {
        return $this->productId;
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
