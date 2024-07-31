<?php

namespace App\Features\Carts\Command;

class DeleteCartCommand
{
    private string $cartId;
    private string $customerId;

    private function __construct(string $cartId, string $customerId)
    {
        $this->cartId = $cartId;
        $this->customerId = $customerId;
    }

    public static function create(string $cartId, string $customerId): self
    {
        return new self($cartId, $customerId);
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }
}
