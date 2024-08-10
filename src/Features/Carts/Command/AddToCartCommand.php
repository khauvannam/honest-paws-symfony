<?php

namespace App\Features\Carts\Command;

class AddToCartCommand
{
    private CreateCartItemCommand $cartItem;

  
    public function __construct()
    {
    }

    public function getCartItem(): CreateCartItemCommand
    {
        return $this->cartItem;
    }

    public function setCartItem(CreateCartItemCommand $cartItem): AddToCartCommand
    {
        $this->cartItem = $cartItem;
        return $this;
    }

}
