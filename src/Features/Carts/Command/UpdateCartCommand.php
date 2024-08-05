<?php

namespace App\Features\Carts\Command;

use App\Entity\Carts\CartItemRequest;

class UpdateCartCommand
{
    private string $cartId;
    private string $customerId;
    private array $cartItemRequests;

    private function __construct(string $cartId, string $customerId, array $cartItemRequests)
    {
        $this->cartId = $cartId;
        $this->customerId = $customerId;
        $this->cartItemRequests = $cartItemRequests;
    }

    public static function create(string $cartId, string $customerId, array $cartItemRequests): self
    {
        return new self($cartId, $customerId, $cartItemRequests);
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
