<?php

namespace App\Features\Carts\Command;

class UpdateCartCommand
{
    private string $cartId;
    private string $customerId;
    private array $cartItemRequests;

    public function __construct(string $customerId, string $cartId, array $cartItemRequests)
    {
        $this->cartId = $cartId;
        $this->customerId = $customerId;
        $this->cartItemRequests = $cartItemRequests;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getCartItemRequests(): array
    {
        return $this->cartItemRequests;
    }
}
