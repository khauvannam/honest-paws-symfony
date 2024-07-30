<?php

namespace App\Features\Carts\Handlers;

use App\Entity\Carts\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Features\Carts\Commands\DeleteCartCommand;
use App\Repository\Carts\CartRepository;

#[AsMessageHandler]
class DeleteCartCommandHandler
{
    private CartRepository $cartRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->cartRepository = $entityManager->getRepository(Cart::class);
    }

    public function __invoke(DeleteCartCommand $command, CartRepository $cartRepository): void
    {
        $cart = $this->cartRepository->findById;

        if ($cart) {
            $this->cartRepository->remove($cart);
        } else {
            throw new \Exception('Cart not found');
        }
    }
}
