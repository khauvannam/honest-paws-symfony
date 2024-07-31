<?php

namespace App\Features\Carts\Command;

use Symfony\Component\Uid\Uuid;

class DeleteCartCommand
{
    private Uuid $cartId;
    private Uuid $customerId;
    private function __construct(Uuid $cartId,Uuid $customerId)
    {
        $this->cartId = $cartId;
        $this->customerId = $customerId
    }

    public static function create(Uuid $cartId,Uuid $customerId): self
    {
        return new self($cartId, $customerId);
    }
    public function getCustomerId(): Uuid
    {
        return $this->customerId;
    }
    public function getCartId(): Uuid
    {
        return $this->cartId;
    }
}
