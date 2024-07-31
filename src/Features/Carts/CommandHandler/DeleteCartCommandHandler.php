<?php

namespace App\Features\Carts\CommandHandler;

use App\Features\Carts\Command\DeleteCartCommand;
use App\Repository\Carts\CartRepository;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteCartCommandHandler
{


    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function __invoke(DeleteCartCommand $command, CartRepository $cartRepository): void
    {
        $cart = $this->cartRepository->findById($command->getCartId());

        if ($cart) {
            $this->cartRepository->remove($cart);
        } else {
            throw new Exception('Cart not found');
        }
    }
}
