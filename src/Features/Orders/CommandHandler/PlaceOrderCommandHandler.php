<?php

namespace App\Features\Orders\CommandHandler;

use App\Entity\Carts\CartItem;
use App\Entity\Carts\CartStatus;
use App\Entity\Orders\OrderBase;
use App\Entity\Orders\OrderLine;
use App\Features\Orders\Command\PlaceOrderCommand;
use App\Repository\Carts\CartRepository;
use App\Repository\Orders\OrderRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Services\MailerService;
use App\Entity\Users\User;
use App\Repository\Identities\UserRepository;

#[AsMessageHandler]
class PlaceOrderCommandHandler
{

    public function __construct(private OrderRepository $orderRepository, private CartRepository $cartRepository, private MailerService $mailerService, private UserRepository $userRepository) {}

    public function __invoke(PlaceOrderCommand $command): OrderBase
    {
        $cart = $command->getCart();
        $order = new OrderBase($cart->getCustomerId(), $command->getShippingAddress());
        /**
         * @var CartItem $cartItem
         */


        foreach ($cart->getCartItems() as $cartItem) {
            $orderLine = new OrderLine($cartItem->getProductId(), $cartItem->getName(), $cartItem->getImageUrl(), $cartItem->getQuantity(), $cartItem->getPrice());
            $order->addOrderLine($orderLine);
        }
        $this->orderRepository->save($order);
        $cart->setCartStatus(CartStatus::checkout);


        $user = $this->userRepository->find($cart->getCustomerId());
        if ($user) {
            $this->mailerService->sendOrderConfirmationEmail($user->getEmail(), $order, $user->getUsername());
        }

        $this->cartRepository->save($cart);
        return $order;
    }
}
