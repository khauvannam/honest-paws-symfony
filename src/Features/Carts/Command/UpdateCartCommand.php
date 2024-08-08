<?php

namespace App\Features\Carts\Command;

class UpdateCartCommand
{
    private string $customerId = '';
    private CreateCartItemCommand $cartItem;

    public function getCartItem(): CreateCartItemCommand
    {
        return $this->cartItem;
    }

    public function setCartItem(CreateCartItemCommand $cartItem): UpdateCartCommand
    {
        $this->cartItem = $cartItem;
        return $this;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): UpdateCartCommand
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function __construct()
    {
    }
}
