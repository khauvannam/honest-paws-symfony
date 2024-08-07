<?php

declare(strict_types=1);

namespace App\Controller\Orders;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig');
    }
    #[Route('/order_item', name: 'order_item')]
    public function order_item(): Response
    {
        return $this->render('order/order_item.html.twig');
    }
}
