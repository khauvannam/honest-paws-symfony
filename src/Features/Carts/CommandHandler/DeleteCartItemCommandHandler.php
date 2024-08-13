<?php

namespace App\Features\Carts\CommandHandler;

use App\Features\Carts\Command\DeleteCartItemCommand;
use App\Repository\Carts\CartItemRepository;
use App\Repository\Carts\CartRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DeleteCartItemCommandHandler
{

    public function __construct(private CartRepository $repository, private CartItemRepository $cartItemRepository)
    {
    }

    public function __invoke(DeleteCartItemCommand $command): void
    {
        $cart = $this->repository->findOneBy(['id' => $command->getCartId()]);
        $cartItem = $this->cartItemRepository->findOneBy(['id' => $command->getCartItemId(), 'cart' => $cart]);
        $cart->removeCartItem($cartItem);
        $this->cartItemRepository->remove($cartItem);
        if ($cart->getCartItems()->count() === 0) {
            $this->repository->remove($cart);
        }
    }
}