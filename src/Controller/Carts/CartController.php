<?php

namespace App\Controller\Carts;

use App\Features\Carts\Command\AddToCartCommand;
use App\Features\Carts\Command\CreateCartItemCommand;
use App\Features\Carts\Command\DeleteCartItemCommand;
use App\Features\Carts\Command\UpdateCartCommand;
use App\Features\Carts\Query\GetCartByCustomerId;
use App\Features\Carts\Type\CreateCartItemType;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
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
        $cartItem = new CreateCartItemCommand();
        $cart = new AddToCartCommand();
        $cart->setCartItem($cartItem);

        $form = $this->createForm(CreateCartItemType::class, $cartItem);
        if ($form->handleRequest($request)->isSubmitted()) {
            $this->bus->dispatch($cart);
            return $this->redirectToRoute('cart_list');
        }
        return $this->render("product/product_details.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/cart/list', name: 'cart_list', methods: ['GET', 'POST'])]
    public function list(): Response
    {
        $command = new GetCartByCustomerId();
        $cart = $this->service::invoke($this->bus->dispatch($command));

        return $this->render('cart/list-carts.html.twig', ['cart' => $cart]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/cart/update/{cartId}', name: 'cart_update', methods: ['POST', 'GET'])]
    public function update(Request $request, string $cartId): Response
    {
        $quantities = $request->request->all('quantities');
        $command = new UpdateCartCommand($quantities, $cartId);
        $this->bus->dispatch($command);
        $cartCommand = new GetCartByCustomerId();
        $cart = $this->service::invoke($this->bus->dispatch($cartCommand));

        return $this->redirectToRoute('cart_list', ['cart' => $cart]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/cart/delete', name: 'cart_delete', methods: ['POST', 'GET'])]
    public function delete(#[MapQueryParameter] string $cartId, #[MapQueryParameter] string $cartItemId): Response
    {
        $command = new DeleteCartItemCommand($cartId, $cartItemId);

        $this->bus->dispatch($command);
        $cartCommand = new GetCartByCustomerId();
        $cart = $this->service::invoke($this->bus->dispatch($cartCommand));

        return $this->redirectToRoute('cart_list', ['cart' => $cart]);
    }
}
