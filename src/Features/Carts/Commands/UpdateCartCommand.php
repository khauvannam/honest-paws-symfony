<?php

namespace App\Features\Carts\Commands;

class UpdateCartCommand
{
    private ?int $cartId;
    private string $customerId;

    public function __construct(string $customerId, ?int $cartId = null)
    {
        $this->cartId = $cartId;
        $this->customerId = $customerId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getCartId(): ?int
    {
        return $this->cartId;
    }
}
