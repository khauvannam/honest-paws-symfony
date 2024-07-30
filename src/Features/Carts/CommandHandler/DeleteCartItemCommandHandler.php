<?php

namespace App\Features\Carts\Command\Commands\Handlers;

use App\Entity\Carts\CartItem;
use App\Features\Carts\Command\Commands\DeleteCartItemCommand;
use App\Repository\Carts\CartItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteCartItemCommandHandler
{

    private cartItemRepository $cartItemRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->cartItemRepository = $entityManager->getRepository(cartItem::class);
    }

    public function __invoke(DeleteCartItemCommand $command, CartItem $cartItem): void
    {
        $cartItem = $this->cartItemRepository->findById;

        if ($cartItem) {
            $this->cartItemRepository->remove($cartItem);
        }
    }
}
