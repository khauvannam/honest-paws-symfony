<?php

namespace App\Controller\Homes;

use App\Features\Homes\Query\GetCategoriesAndProductsQuery;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{


    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/', name: 'home')]
    public function index(int $productLimit = 4, int $categoryLimit = 4 ): Response
    {
        $command = new GetCategoriesAndProductsQuery($productLimit, $categoryLimit);
        $handler = $this->bus->dispatch($command);
        $result = GetEnvelopeResultService::invoke($handler);
        return $this->render('home/home.html.twig', $result);

    }
}