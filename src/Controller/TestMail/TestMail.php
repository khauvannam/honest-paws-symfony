<?php

namespace App\Controller\TestMail;

use App\Features\Homes\Query\GetCategoriesAndProductsQuery;
use App\Features\Products\Query\GetProductCategoryId;
use App\Services\GetEnvelopeResultService;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestMail extends AbstractController
{
    private MailerService $mailerService;
    private MessageBusInterface $bus;

    public function __construct(MailerService $mailerService, MessageBusInterface $bus)
    {
        $this->mailerService = $mailerService;
        $this->bus = $bus;
    }

    #[Route('/mail', name: 'mail', methods: ['GET'])]
    public function index(): Response
    {
        $to = 'chungthanhnguyen277@gmail.com';
        $username = 'TestUser';

        try {
            $this->mailerService->sendRegistrationEmail($to, $username);
            $message = 'Test email has been sent.';
        } catch (\Exception $e) {
            $message = 'Failed to send test email: ' . $e->getMessage();
        } catch (TransportExceptionInterface $e) {
           $message = 'Failed to send test email: ' . $e->getMessage(); 
        }

        return new Response($message);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/all-products', name: 'all_products', methods: ['GET'])]
    public function AllProducts(#[MapQueryParameter]int $productLimit, #[MapQueryParameter]int $categoryLimit): Response
    {
        $command = new GetCategoriesAndProductsQuery( $productLimit, $categoryLimit);
        $handler = $this->bus->dispatch($command);
        $result = GetEnvelopeResultService::invoke($handler);
        return $this->render('all_products.html.twig', $result);

    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/category-products/{id}', name: 'category_by_id', methods: ['GET'])]
    public function ProductByCategoryId(string $id): Response
    {
        $command = new GetProductCategoryId($id);
        $handler = $this->bus->dispatch($command);
        $result = GetEnvelopeResultService::invoke($handler);
        return $this->render('category_by_id.html.twig', $result);

    }
}
