<?php

namespace App\Features\Carts\CommandHandler;

use App\Features\Carts\Command\UpdateCartCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Carts\CartRepository;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCartCommandHandler 
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(UpdateCartCommand $command): void
    {
        $cartId = $command->getCartId();
        $customerId = $command->getCustomerId();
        $cartItemRequests = $command->getCartItemRequests();

        $cart = $this->cartRepository->findByIdAndCustomerId($cartId, $customerId);

        if ($cart === null) {
            throw new Exception('Cart not found');
        }
        $cart->RemoveAllCartItemNotExist($cartItemRequests);
        foreach ($cartItemRequests as $cartItemRequest) {
            $cart->Update($cartItemRequest);
        }
        $this->cartRepository->update($cart);
    }
}
