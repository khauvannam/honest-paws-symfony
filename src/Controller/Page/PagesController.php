<?php

// src/Controller/PageController.php
namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/learn/dogs', name: 'dogs')]
    public function dogs(): Response
    {
        return $this->render('page/dogs.html.twig');
    }

    #[Route('/shop/cbd-oil-dogs', name: 'shop_cbd_oil_dogs')]
    public function cbdOilDogs(): Response
    {
        return $this->render('page/shop_cbd_oil_dogs.html.twig');
    }

    #[Route('/shop/cbd-oil-cats', name: 'shop_cbd_oil_cats')]
    public function cbdOilCats(): Response
    {
        return $this->render('page/shop_cbd_oil_cats.html.twig');
    }

    #[Route('/shop/probiotics-dogs', name: 'shop_probiotics_dogs')]
    public function probioticsDogs(): Response
    {
        return $this->render('page/shop_probiotics_dogs.html.twig');
    }

    #[Route('/shop/probiotics-cats', name: 'shop_probiotics_cats')]
    public function probioticsCats(): Response
    {
        return $this->render('page/shop_probiotics_cats.html.twig');
    }

    #[Route('/shop/salmon-oil-dogs', name: 'shop_salmon_oil_dogs')]
    public function salmonOilDogs(): Response
    {
        return $this->render('page/shop_salmon_oil_dogs.html.twig');
    }

    #[Route('/customer/account', name: 'customer_account')]
    public function account(): Response
    {
        return $this->render('page/account.html.twig');
    }

    #[Route('/customer/track-order', name: 'track_order')]
    public function trackOrder(): Response
    {
        return $this->render('page/track_order.html.twig');
    }

    #[Route('/customer/flea-market', name: 'flea_market')]
    public function fleaMarket(): Response
    {
        return $this->render('page/flea_market.html.twig');
    }

    #[Route('/customer/help-center', name: 'help_center')]
    public function helpCenter(): Response
    {
        return $this->render('page/help_center.html.twig');
    }
}
