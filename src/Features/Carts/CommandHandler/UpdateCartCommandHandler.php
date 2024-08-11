<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\Cart;
use App\Features\Carts\Command\UpdateCartCommand;
use App\Repository\Carts\CartItemRepository;
use App\Repository\Carts\CartRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCartCommandHandler
{

    public function __construct(private CartRepository $cartRepository, private CartItemRepository $cartItemRepository)
    {
    }

    public function __invoke(UpdateCartCommand $command): Cart
    {
        $cart = $this->cartRepository->findOneBy(['id' => $command->getCartId()]);
//        $cartItemList = [];
        foreach ($command->getCartItemList() as $itemId => $quantity) {
            $cartItem = $this->cartItemRepository->findOneBy(['id' => $itemId]);
            if (is_numeric($quantity) && $quantity >= 0) {
                $cart->updateCartItemQuantity($cartItem, (int)$quantity);
            }

//            $cartItemList[$itemId] = $cartItem;
            $this->cartItemRepository->save($cartItem);
        }

//        dd($cartItemList);
        $this->cartRepository->save($cart);
        return $cart;
    }
}