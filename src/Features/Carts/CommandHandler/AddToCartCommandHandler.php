<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\Cart;
use App\Entity\Carts\CartItem;
use App\Entity\Carts\CartStatus;
use App\Entity\Users\User;
use App\Features\Carts\Command\AddToCartCommand;
use App\Repository\Carts\CartRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
class AddToCartCommandHandler
{
    private CartRepository $cartRepository;
    private Security $security;
    private RequestStack $requestStack;

    public function __construct(
        CartRepository $cartRepository,
        Security       $security,
        RequestStack   $requestStack
    )
    {
        $this->cartRepository = $cartRepository;
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    public function __invoke(AddToCartCommand $command): Cart
    {
        /**
         * @var User|null $user
         */
        $user = $this->security->getUser();
        $cartItemCommand = $command->getCartItem();
        $session = $this->requestStack->getSession();

        // Determine the customer ID based on the user or guest session
        $customerId = $user ? $user->getId() : $this->getGuestSessionId($session);

        // Retrieve or create the cart
        $cart = $this->getOrCreateCart($customerId);

        // Create and add the cart item
        $cartItem = $this->createCartItem($cartItemCommand);
        $cart->addCartItem($cartItem);

        // Save the cart
        $this->cartRepository->save($cart);

        return $cart;
    }

    private function getGuestSessionId($session): string
    {
        $guestSessionId = $session->get('customerId');

        if (!$guestSessionId) {
            $guestSessionId = 'guest_' . Uuid::v4()->toString();
            $session->set('customerId', $guestSessionId);
        }

        return $guestSessionId;
    }

    private function getOrCreateCart(string $customerId): Cart
    {
        $cart = $this->cartRepository->findOneBy([
            'customerId' => $customerId,
            'cartStatus' => CartStatus::preparing
        ]);

        if (!$cart) {
            $cart = Cart::create($customerId);
        }

        return $cart;
    }

    private function createCartItem($cartItemCommand): CartItem
    {
        return CartItem::create(
            productId: $cartItemCommand->getProductId(),
            name: $cartItemCommand->getName(),
            quantity: $cartItemCommand->getQuantity(),
            price: $cartItemCommand->getPrice(),
            imageUrl: $cartItemCommand->getImgUrl()
        );
    }

}