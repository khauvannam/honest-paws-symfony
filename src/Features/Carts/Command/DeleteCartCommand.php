<?php

namespace App\Features\Carts\Command;

use App\Entity\Carts\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;


class DeleteCartCommand
{
    private function __construct(int $cartId)
    {
        $this->cartId = $cartId;
    }

    private int $cartId;

    public static function Create(int $cartId): self
    {
        return new self($cartId);
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }
}

#[AsMessageHandler]
class DeleteCartCommandHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(DeleteCartCommand $command): void
    {
        $cart = $this->entityManager->getRepository(Cart::class)->find($command->getCartId());

        if ($cart) {
            $this->entityManager->remove($cart);
            $this->entityManager->flush();
        } else {
            throw new \Exception('Cart not found');
        }
    }
}
