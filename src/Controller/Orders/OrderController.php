<?php

declare(strict_types=1);

namespace App\Controller\Orders;

use App\Entity\Users\User;
use App\Features\Carts\Query\GetCartByCustomerId;
use App\Features\Orders\Command\PlaceOrderCommand;
use App\Features\Orders\Type\PlaceOrderType;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    public function __construct(private MessageBusInterface $bus, private GetEnvelopeResultService $service) {}

    #[Route('/order_item', name: 'order_item')]
    public function order_item(): Response
    {
        return $this->render('order/order_item.html.twig');
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/order', name: 'order')]
    public function order(): Response
    {
        $userId = $this->getUser()->getId();
        $command = new GetCartByCustomerId($userId);
        $cart = $this->service::invoke($this->bus->dispatch($command));

        $form = $this->createForm(PlaceOrderType::class);

        return $this->render('order/order.html.twig', ['cart' => $cart, 'form' => $form->createView()]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/order/checkout', name: 'order_checkout')]
    public function order_checkout(Request $request): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $userId = $user->getId();
        $cartCommand = new GetCartByCustomerId($userId);

        $cart = $this->service::invoke($this->bus->dispatch($cartCommand));
        $orderCommand = new PlaceOrderCommand();
        $orderCommand->setCart($cart);
        $this->bus->dispatch($orderCommand);

        $form = $this->createForm(PlaceOrderType::class, $orderCommand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->dispatch($orderCommand);
            return $this->redirectToRoute('home');
        }

        return $this->render('order/order.html.twig', ['cart' => $cart, 'form' => $form->createView()]);
    }
    #[Route('/order_success', name: 'order_success')]
    public function order_success(Request $request): Response
    {
        return $this->render('/security/order_success.html.twig');
    }
}
