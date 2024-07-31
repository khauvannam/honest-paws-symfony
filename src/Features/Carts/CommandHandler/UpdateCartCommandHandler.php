<?php

namespace App\Features\Carts\CommandHandler;

use App\Features\Carts\Command\UpdateCartCommand;
use App\Repository\Carts\CartRepository;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCartCommandHandler
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function __invoke(UpdateCartCommand $command): void
    {
<<<<<<< HEAD

        if (!$cart) {
            $cartItem = Cart::create(
                $command->getCustomerId(),

            );
        } else { // sai logic
            $cart->update($command->getCustomerId());
        }
=======
        $cartId = $command->getCartId();
        $customerId = $command->getCustomerId();

        $cart = $this->cartRepository->findByIdAndCustomerId($cartId, $customerId);

        if ($cart === null) {
            throw new Exception('Cart not found');
        }
        $this->cartRepository->update($cart);
>>>>>>> origin/namdeptrai
    }
}
