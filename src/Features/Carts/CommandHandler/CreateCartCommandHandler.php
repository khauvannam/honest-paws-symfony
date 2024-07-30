<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\Cart;
use Doctrine\ORM\EntityManagerInterface;
use App\Features\Carts\CreateCartCommand;
use App\Repository\Carts\CartRepository;

class CreateCartCommandHandler
{
    private CartRepository $cartRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->cartRepository = $entityManager->getRepository(Cart::class);
    }

    public function __invoke(CreateCartCommand $command, Cart $cart): void
    {
        $cart = Cart::Create($command->getCustomerId());

        $this->cartRepository->save($cart);
    }
}
