<?php

namespace App\Features\Carts\Commands\Handlers;

use App\Entity\Carts\Cart;
use App\Features\Carts\Commands\UpdateCartCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Repository\CartRepository;

class UpdateCartCommandHandler
{
    private CartRepository $cartRepository;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->cartRepository = $entityManager->getRepository(Cart::class);
    }

    public function __invoke(UpdateCartCommand $command, Cart $cart): void
    {
        $cart = $this->cartRepository->findById;


        if ($cart->getId() !== $cart->getId()) {
            $cart = $this->cartRepository->findById;
            if (!$cart) {
                throw new \Exception('Cart not found');
            }
        }

        if (!$cart) {
            $cart = Cart::Create($command->getCustomerId());
        } else {
            $cart->Update($command->getCustomerId());
        }

        $this->cartRepository->save($cart);
    }
}
