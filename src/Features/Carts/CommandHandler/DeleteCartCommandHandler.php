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

    /**
     * @throws Exception
     */
    public function __invoke(DeleteCartCommand $command): void
    {
        $cart = $this->cartRepository->findByIdAndCustomerId(
            $command->getCartId(),
            $command->getCustomerId()
        );

        if ($cart) {
            $this->cartRepository->remove($cart);
        } else {
            throw new Exception("Cart not found");
        }
    }
}
