<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\Cart;
use App\Entity\Carts\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use App\Features\Carts\CreateCartItemCommand;
use App\Repository\Carts\CartItemRepository;

class CreateCartItemCommandHandler
{

    private CartItemRepository $cartItemRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->cartItemRepository = $entityManager->getRepository(Cart::class);
    }

    public function __invoke(CreateCartItemCommand $command, Cart $cart): void
    {
        // Tìm cart từ CartId
        $cart = $this->cartItemRepository->findById;

        if (!$cart) {
            throw new \Exception('Cart not found');
        }

        // Tạo CartItem
        $cartItem = CartItem::create(
            $command->getProductId(),
            $command->getVariantId(),
            $command->getName(),
            $command->getQuantity(),
            $command->getPrice(),
            $command->getImageUrl(),
            $command->getDescription()
        );

        // Gán CartItem vào Cart
        $cart->addCartItem($cartItem);

        $this->cartItemRepository->save($cart);
    }
}
