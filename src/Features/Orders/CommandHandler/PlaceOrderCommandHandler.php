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


#[AsMessageHandler]
class PlaceOrderCommandHandler
{

    public function __construct(private OrderRepository $orderRepository, private CartRepository $cartRepository, private MailerService $mailerService) {}

    public function __invoke(PlaceOrderCommand $command): OrderBase
    {
        $cart = $command->getCart();
        /**
         * @var CartItem $cartItem
         */

        $order = new OrderBase($cart->getCustomerId(), $command->getShippingAddress());
        foreach ($cart->getCartItems() as $cartItem) {
            $orderLine = new OrderLine($cartItem->getProductId(), $cartItem->getName(), $cartItem->getImageUrl(), $cartItem->getQuantity(), $cartItem->getPrice());
            $order->addOrderLine($orderLine);
        }
        $this->orderRepository->save($order);
        $cart->setCartStatus(CartStatus::checkout);

        $this->mailerService->sendOrderConfirmationEmail($customer->getEmail(), $order);


        $this->cartRepository->save($cart);
        return $order;
    }
}
