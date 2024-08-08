<?php

namespace App\Controller\Carts;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }


    #[Route('/cart/new', name: 'cart_new', methods: ['GET', 'POST'])]
    public function createAsync(Request $request, string $customerId): RedirectResponse|Response
    {
       
    }

}
