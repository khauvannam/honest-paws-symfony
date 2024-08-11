<?php

namespace App\Features\Carts\Command;

class DeleteCartItemCommand
{
    private string $cartItemId;
    private string $cartId;

    public function __construct($cartId, $cartItemId)
    {
        $this->cartId = $cartId;
        $this->cartItemId = $cartItemId;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function setCartId(string $cartId): DeleteCartItemCommand
    {
        $this->cartId = $cartId;
        return $this;
    }

    public function getCartItemId(): string
    {
        return $this->cartItemId;
    }

    public function setCartItemId($cartItemId): static
    {
        $this->cartItemId = $cartItemId;
        return $this;
    }
}