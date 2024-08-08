<?php

namespace App\Features\Carts\CommandHandler;

use App\Entity\Carts\Cart;
use App\Entity\Carts\CartItem;
use App\Entity\Carts\CartStatus;
use App\Entity\Users\User;
use App\Features\Carts\Command\UpdateCartCommand;
use App\Repository\Carts\CartRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCartCommandHandler
{
    private CartRepository $cartRepository;
    private Security $security;
    private SessionInterface $session;

    public function __construct(
        CartRepository   $cartRepository,
        Security         $security,
        SessionInterface $session
    )
    {
        $this->cartRepository = $cartRepository;
        $this->security = $security;
        $this->session = $session;
    }

    public function __invoke(UpdateCartCommand $command)
    {
        /**
         * @var User|null $user The currently logged-in user or null if not logged in
         */
        $user = $this->security->getUser();
        $cartItemCommand = $command->getCartItem();
        global $cartItem;

        $cartItem = CartItem::create(productId: $cartItemCommand->getProductId(), name: $cartItemCommand->getName(), quantity: $cartItemCommand->getQuantity(), price: $cartItemCommand->getPrice(), imageUrl: $cartItemCommand->getImgUrl());

        if (!$user) {
            // Use session for guest users
            $cart = $this->session->get('cart_id');
            if (!$cart) {
                $newCart = Cart::create(null); // or use a special guest identifier
                $this->session->set('cart_id', serialize($newCart));
                return $cart;
            }
            return $cart;
        }
        // Retrieve the cart for logged-in users
        $cart = $this->cartRepository->findOneBy([
            'customerId' => $command->getCustomerId(),
            'cartStatus' => CartStatus::preparing
        ]);

        if (!$cart) {
            $cart = Cart::create($command->getCustomerId());
            $this->cartRepository->save($cart);
            return $cart;
        }
        $cart->addCartItem($cartItem);

        return $cart;
    }
}