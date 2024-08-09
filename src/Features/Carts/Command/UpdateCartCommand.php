<?php

namespace App\Features\Carts\Command;

class UpdateCartCommand
{
    private string $customerId;
    private CreateCartItemCommand $cartItem;

    /**
     * @param string $customerId
     */
    public function __construct(string $customerId)
    {
        $this->customerId = $customerId;
    }

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


}
