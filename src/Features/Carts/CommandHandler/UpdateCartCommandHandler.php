<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\Cart;
use App\Features\Carts\Command\UpdateCartCommand;
use App\Repository\Carts\CartRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCartCommandHandler
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function __invoke(UpdateCartCommand $command, Cart $cart): void
    {

        if (!$cart) {
            $cartItem = Cart::create(
                $command->getCustomerId(),

            );
        } else { // sai logic
            $cart->update($command->getCustomerId());
        }
    }
}
