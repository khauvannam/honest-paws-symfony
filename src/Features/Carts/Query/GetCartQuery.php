<?php

namespace App\Features\Carts\Query;

class GetCartQuery
{
    private string $cartId;
    private string $customerId;

    public function __construct(string $cartId, string $customerId)
    {
        $this->cartId = $cartId;
        $this->customerId = $customerId;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }
}
