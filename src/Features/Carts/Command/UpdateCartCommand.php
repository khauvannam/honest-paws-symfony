<?php

namespace App\Features\Carts\Command;

use Doctrine\Common\Collections\Collection;

class UpdateCartCommand
{
    private string $customerId = '';
    private array $cartItems = [];

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): UpdateCartCommand
    {
        $this->customerId = $customerId;
        return $this;
    }

    public function getCartItems(): array
    {
        return $this->cartItems;
    }

    public function setCartItems(array $cartItems): UpdateCartCommand
    {
        $this->cartItems = $cartItems;
        return $this;
    }

    public function __construct()
    {
    }
}
