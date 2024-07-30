<?php

namespace App\Features\Carts\Command;

use App\Entity\Carts\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

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
#[AsMessageHandler]
class DeleteCartItemCommandHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(DeleteCartItemCommand $command): void
    {
        $cartItem = $this->entityManager->getRepository(CartItem::class)->find($command->getCartItemId());

        if ($cartItem) {
            $this->entityManager->remove($cartItem);
            $this->entityManager->flush();
        }
    }
}
