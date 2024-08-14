<?php

namespace App\Controller\Admin;

use App\Features\Homes\Query\GetCategoriesAndProductsQuery;
use App\Features\Products\Command\CreateProductCommand;
use App\Features\Products\Type\CreateProductType;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('admin.html.twig');
    }
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(int $productLimit = 100, int $categoryLimit = 100): Response
    {
        $command = new GetCategoriesAndProductsQuery($productLimit, $categoryLimit, null);
        $handler = $this->bus->dispatch($command);
        $result = GetEnvelopeResultService::invoke($handler);
        return $this->render('admin/dashboard.html.twig', $result);
    }
    #[Route('/admin/products', name: 'admin_products')]
        public function products(Request $request, int $productLimit = 100, int $categoryLimit = 100): Response
        {
            // Fetch products and categories
            $command = new GetCategoriesAndProductsQuery($productLimit, $categoryLimit, null);
            $handler = $this->bus->dispatch($command);
            $result = GetEnvelopeResultService::invoke($handler);

            // Create product form
            $createProductCommand = new CreateProductCommand();
            $form = $this->createForm(CreateProductType::class, $createProductCommand);
            $form->handleRequest($request);

            // Handle form submission
            if ($form->isSubmitted() && $form->isValid()) {
                $createProductCommand->setImgFile($form->get('imgFile')->getData());
                $this->bus->dispatch($createProductCommand);

                return $this->redirectToRoute('product_success');
            }

            // Merge product and category data with the form view
            return $this->render('admin/products.html.twig', array_merge($result, [
                'form' => $form->createView(),
            ]));
        }
}