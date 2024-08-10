<?php

namespace App\Features\Orders\Command;

use App\Entity\Carts\Cart;

class PlaceOrderCommand
{
    private string $shippingAddress = '';
    private string $shippingMethod = '';
    private ?string $email;
    private Cart $cart;

    public function __construct()
    {
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): PlaceOrderCommand
    {
        $this->email = $email;
        return $this;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): PlaceOrderCommand
    {
        $this->cart = $cart;
        return $this;
    }

    public function getShippingMethod(): string
    {
        return $this->shippingMethod;
    }

    public function setShippingMethod(string $shippingMethod): PlaceOrderCommand
    {
        $this->shippingMethod = $shippingMethod;
        return $this;
    }

    public function getShippingAddress(): string
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(string $shippingAddress): PlaceOrderCommand
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }
}