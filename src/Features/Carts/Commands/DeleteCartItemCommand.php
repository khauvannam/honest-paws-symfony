<?php

namespace App\Features\Carts\Commands;

class DeleteCartItemCommand
{
    private int $cartItemId;

    private function __construct(int $cartItemId)
    {
        $this->cartItemId = $cartItemId;
    }

    public static function create(int $cartItemId): self
    {
        return new self($cartItemId);
    }

    public function getCartItemId(): int
    {
        return $this->cartItemId;
    }
}
