<?php

// src/Controller/PageController.php
namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PagesController extends AbstractController
{
    #[Route('/learn/faqs', name: 'faqs')]
    public function faqs(): Response
    {
        return $this->render('page/faqs.html.twig');
    }

    #[Route('/learn/ingredients', name: 'ingredients')]
    public function ingredients(): Response
    {
        return $this->render('page/ingredients.html.twig');
    }

    #[Route('/learn/news', name: 'news')]
    public function news(): Response
    {
        return $this->render('page/news.html.twig');
    }

    #[Route('/customer/help-center', name: 'help_center')]
    public function helpCenter(): Response
    {
        return $this->render('page/help_center.html.twig');
    }
}
