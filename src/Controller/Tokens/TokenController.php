<?php

declare(strict_types=1);

namespace App\Controller\Tokens;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TokenController extends AbstractController
{
    #[Route('/token')]
    public function index(): Response
    {
        return $this->render('token/index.html.twig');
    }
}
