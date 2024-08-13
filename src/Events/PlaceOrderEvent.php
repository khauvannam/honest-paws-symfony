<?php

namespace App\Events;

class PlaceOrderEvent
{
    private string $cartId;
    
    private array $productQuantity = [];

    public function getProductQuantity(): array
    {
        return $this->productQuantity;
    }

    public function setProductQuantity(array $productQuantity): PlaceOrderEvent
    {
        $this->productQuantity = $productQuantity;
        return $this;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function setCartId(string $cartId): void
    {
        $this->cartId = $cartId;
    }
}