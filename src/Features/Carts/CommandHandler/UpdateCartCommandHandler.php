<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\Cart;
use App\Entity\Carts\CartItem;
use App\Entity\Carts\CartStatus;
use App\Features\Carts\Command\UpdateCartCommand;
use App\Repository\Carts\CartItemRepository;
use App\Repository\Carts\CartRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCartCommandHandler
{
    private CartRepository $cartRepository;
    private Security $security;
    private RequestStack $requestStack;
    private cartItemRepository $cartItemRepository;

    public function __construct(
        CartItemRepository $cartItemRepository,
        CartRepository     $cartRepository,
        Security           $security,
        RequestStack       $requestStack
    )
    {
        $this->cartRepository = $cartRepository;
        $this->security = $security;
        $this->requestStack = $requestStack;
        $this->cartItemRepository = $cartItemRepository;
    }

    public function __invoke(UpdateCartCommand $command): Cart
    {

        $cartItemCommand = $command->getCartItem();

        $cartItem = CartItem::create(productId: $cartItemCommand->getProductId(), name: $cartItemCommand->getName(), quantity: $cartItemCommand->getQuantity(), price: $cartItemCommand->getPrice(), imageUrl: $cartItemCommand->getImgUrl());

        // Retrieve the cart for logged-in users
        $cart = $this->cartRepository->findOneBy([
            'customerId' => $command->getCustomerId(),
            'cartStatus' => CartStatus::preparing
        ]);

        if (!$cart) {
            $cart = Cart::create($command->getCustomerId());
        }
        $cart->addCartItem($cartItem);
        $this->cartRepository->save($cart);

        return $cart;
    }

}