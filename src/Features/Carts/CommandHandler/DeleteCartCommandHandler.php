<?php

namespace App\Features\Carts\Command\Handlers;

use App\Entity\Carts\Cart;
use App\Features\Carts\Command\Commands\DeleteCartCommand;
use App\Repository\Carts\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

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
