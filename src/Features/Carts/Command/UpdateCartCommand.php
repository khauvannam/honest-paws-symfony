<?php

namespace App\Features\Carts\Command;

use Symfony\Component\Uid\Uuid;

class UpdateCartCommand
{
    private Uuid $cartId;
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

    public function getCartId(): Uuid
    {
        return $this->cartId;
    }
}
