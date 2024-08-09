<?php

namespace App\Controller\Carts;

use App\Entity\Users\User;
use App\Features\Carts\Command\CreateCartItemCommand;
use App\Features\Carts\Command\UpdateCartCommand;
use App\Features\Carts\Query\GetCartByCustomerId;
use App\Features\Carts\Type\CreateCartItemType;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private MessageBusInterface $bus;
    private GetEnvelopeResultService $service;

    public function __construct(MessageBusInterface $bus, getEnvelopeResultService $service)
    {
        $this->bus = $bus;
        $this->service = $service;
    }


    /**
     * @throws ExceptionInterface
     */
    #[Route('/cart/new', name: 'cart_new', methods: ['GET', 'POST'])]
    public function createAsync(Request $request): RedirectResponse|Response
    {
        /**
         * @var User|null $user The currently logged-in user or null if not logged in
         */
        $user = $this->getUser();
        $userId = $user->getId();
        $cartItem = new CreateCartItemCommand();
        $cart = new UpdateCartCommand($userId);
        $cart->setCartItem($cartItem);

        $form = $this->createForm(CreateCartItemType::class, $cartItem);

        if ($form->handleRequest($request)->isSubmitted()) {
            $this->bus->dispatch($cart);
            return $this->redirectToRoute('cart_list', ['customerId' => $userId]);
        }
        return $this->render("product/product_details.html.twig", ['form' => $form->createView()]);
    }

    #[Route('/cart/list', name: 'cart_list', methods: ['GET', 'POST'])]
    public function list(): Response
    {
        /**
         * @var User|null $user The currently logged-in user or null if not logged in
         */
        $user = $this->getUser();
        $userId = $user->getId();
        $command = new GetCartByCustomerId($userId);
        $cart = $this->service::invoke($this->bus->dispatch($command));

        return $this->render('cart/list-carts.html.twig', ['cart' => $cart]);
    }
}
