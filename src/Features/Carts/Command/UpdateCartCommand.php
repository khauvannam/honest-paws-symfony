<?php

namespace App\Features\Carts\Command;

class UpdateCartCommand
{
    private string $cartId;
    private string $customerId;

    public function __construct(string $customerId,  $cartId )
    {
        $this->cartId = $cartId;
        $this->customerId = $customerId;
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
