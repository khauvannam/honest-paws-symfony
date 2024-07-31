<?php

namespace App\Features\Carts\Command;

use Symfony\Component\Uid\Uuid;

class DeleteCartCommand
{
    private Uuid $cartId;
    private function __construct(Uuid $cartId)
    {
        $this->cartId = $cartId;
    }

    public static function create(Uuid $cartId): self
    {
        return new self($cartId);
    }

    public function getCartId(): Uuid 
    {
        return $this->cartId;
    }
}
