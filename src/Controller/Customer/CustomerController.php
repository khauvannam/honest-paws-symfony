<?php

declare(strict_types=1);

namespace App\Controller\Customer;

use App\Features\Orders\Query\GetOrdersByCustomerId;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class CustomerController extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    #[Route('/customer')]
    public function index(): Response
    {
        return $this->render('customer/index.html.twig');
    }

    #[Route('/customer/order/{id}', name: 'customer_order', methods: ['GET', 'POST'])]
    public function order(string $id): Response
    {
        $command = new GetOrdersByCustomerId($id);
        $handler = $this->bus->dispatch($command);
        $result = GetEnvelopeResultService::invoke($handler);
        return $this->render('customer/order.html.twig', ['orders' => $result]);
    }
}
