<?php

namespace App\Features\Carts\Command;

class UpdateCartCommand
{
    private array $cartItemList;
    private string $cartId;

    /**
     * @param array $cartItemList
     * @param string $cartId
     */
    public function __construct(array $cartItemList, string $cartId)
    {
        $this->cartItemList = $cartItemList;
        $this->cartId = $cartId;
    }

    public function getCartItemList(): array
    {
        return $this->cartItemList;
    }

    public function setCartItemList(array $cartItemList): UpdateCartCommand
    {
        $this->cartItemList = $cartItemList;
        return $this;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function setCartId(string $cartId): UpdateCartCommand
    {
        $this->cartId = $cartId;
        return $this;
    }

}