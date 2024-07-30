<?php

namespace App\Features\Carts\Commands;

class DeleteCartCommand
{
    private function __construct(private int $cartId)
    {
    }

    public static function create(int $cartId): self
    {
        return new self($cartId);
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }
}
