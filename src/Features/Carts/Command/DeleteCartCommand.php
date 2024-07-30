<?php

namespace App\Features\Carts\Commands;
namespace App\Features\Carts\Command;

use App\Entity\Carts\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


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
