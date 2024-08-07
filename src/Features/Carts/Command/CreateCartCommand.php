<?php

namespace App\Features\Carts\Command;

class CreateCartCommand
{
    private string $customerId;
    private string $productId;
    private int $quantity;

    private function __construct(string $customerId, string $productId, int $quantity)
    {
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public static function create(string $customerId, string $productId, int $quantity): self
    {
        return new self($customerId, $productId, $quantity);
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
