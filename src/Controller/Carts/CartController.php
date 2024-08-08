<?php

namespace App\Controller\Carts;

use App\Features\Carts\Command\CreateCartItemCommand;
use App\Features\Carts\Command\UpdateCartCommand;
use App\Features\Carts\Type\CreateCartItemType;
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

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }


    /**
     * @throws ExceptionInterface
     */
    #[Route('/cart/new', name: 'cart_new', methods: ['GET', 'POST'])]
    public function createAsync(Request $request): RedirectResponse|Response
    {
        $cartItem = new CreateCartItemCommand();
        $cart = new UpdateCartCommand();
        $cart->setCartItem($cartItem);
        
        $form = $this->createForm(CreateCartItemType::class, $cartItem);
        $form->handleRequest($request);
        
        if ($form->handleRequest($request)->isSubmitted()) {
            $this->bus->dispatch($cart);
            
        }

    }

}
