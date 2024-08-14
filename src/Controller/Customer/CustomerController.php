<?php

declare(strict_types=1);

namespace App\Controller\Customer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CustomerController extends AbstractController
{
    #[Route('/customer')]
    public function index(): Response
    {
        return $this->render('customer/index.html.twig');
    }

    #[Route('/customer/order', name: 'customer_order', methods: ['GET', 'POST'])]
    public function order(): Response
    {

    }
}
