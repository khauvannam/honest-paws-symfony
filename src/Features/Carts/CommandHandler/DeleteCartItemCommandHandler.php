<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\CartItem;
use App\Features\Carts\Command\DeleteCartItemCommand;
use App\Repository\Carts\CartItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteCartItemCommandHandler
{

    private cartItemRepository $cartItemRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->cartItemRepository = $entityManager->getRepository(cartItem::class);
    }

    public function __invoke(DeleteCartItemCommand $command, CartItem $cartItem): void
    {
//        $cartItem = $this->cartItemRepository->findById; sai logic

        if ($cartItem) {
            $this->cartItemRepository->remove($cartItem);
        }
    }
}
