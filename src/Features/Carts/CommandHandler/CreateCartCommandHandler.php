<?php

namespace App\Features\Carts\Command\CommandHandler;

use App\Entity\Carts\Cart;
use App\Features\Carts\Command\CreateCartCommand;
use App\Repository\Carts\CartRepository;
use Doctrine\ORM\EntityManagerInterface;

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
