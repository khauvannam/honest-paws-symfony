<?php

namespace App\Features\Orders\CommandHandler;

use App\Entity\Carts\Cart;
use App\Entity\Carts\CartItem;
use App\Entity\Carts\CartStatus;
use App\Entity\Orders\OrderBase;
use App\Entity\Orders\OrderLine;
use App\Entity\Users\User;
use App\Events\PlaceOrderEvent;
use App\Features\Orders\Command\PlaceOrderCommand;
use App\Repository\Carts\CartRepository;
use App\Repository\Orders\OrderRepository;
use App\Services\MailerService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


#[AsMessageHandler]
readonly class PlaceOrderCommandHandler
{

    public function __construct(
        private OrderRepository          $orderRepository,
        private CartRepository           $cartRepository,
        private MailerService            $mailerService,
        private Security                 $security,
        private EventDispatcherInterface $dispatcher
    )
    {
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(PlaceOrderCommand $command): OrderBase
    {
        $cart = $command->getCart();
        $order = new OrderBase($cart->getCustomerId(), $command->getShippingAddress(), $command->getShippingMethod());
        /**
         * @var CartItem $cartItem
         */
       
        $orderEvent = new PlaceOrderEvent();
        $productQuantity = [];

        foreach ($cart->getCartItems() as $cartItem) {
            $orderLine = new OrderLine($cartItem->getProductId(), $cartItem->getName(), $cartItem->getImageUrl(), $cartItem->getQuantity(), $cartItem->getPrice());
            $order->addOrderLine($orderLine);
            $productQuantity[$cartItem->getProductId()] = $orderLine->getQuantity();
        }
        $this->orderRepository->save($order);

        // publish an event to product
        $orderEvent->setProductQuantity($productQuantity);
        $this->dispatcher->dispatch($orderEvent);

        $this->updateCartStatusToCheckout($cart);

        $this->notifyUserAboutOrder($order);

        return $order;
    }

    private function updateCartStatusToCheckout(Cart $cart): void
    {
        $cart->setCartStatus(CartStatus::checkout);
        $this->cartRepository->update($cart);
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    private function notifyUserAboutOrder(OrderBase $order): void
    {
        /**
         * @var User $user
         */
        $user = $this->security->getUser();

        if ($user) {
            $this->mailerService->sendOrderConfirmationEmail(
                $user->getEmail(),
                $order,
            );
        }
    }
}
