<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\Cart;
use App\Entity\Carts\CartItem;
use App\Features\Carts\CreateCartItemCommand;
use App\Repository\Carts\CartItemRepository;
use Exception;

class CreateCartItemCommandHandler
{
    public function __construct(private CartItemRepository $cartItemRepository)
    {

    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateCartItemCommand $command, Cart $cart): void
    {
        // Tìm cart từ CartId
        $cart = $this->cartItemRepository->findById;

        if (!$cart) {
            throw new Exception('Cart not found');
       }
// sai logic
//        // Tạo CartItem
//        $cartItem = CartItem::create(
//            $command->getProductId(),
//            $command->getVariantId(),
//            $command->getName(),
//            $command->getQuantity(),
//            $command->getPrice(),
//            $command->getImageUrl(),
//            $command->getDescription()
//        );
//
//        // Gán CartItem vào Cart
//        $cart->addCartItem($cartItem);
//
//        $this->cartItemRepository->save($cart);
    }
}
