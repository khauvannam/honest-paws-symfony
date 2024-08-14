<?php

namespace App\Controller\Admin;

use App\Features\Homes\Query\GetCategoriesAndProductsQuery;
use App\Features\Orders\Query\GetOrdersByOrderDateDesc;
use App\Features\Products\Command\CreateProductCommand;
use App\Features\Products\Command\DeleteProductCommand;
use App\Features\Products\Command\UpdateProductCommand;
use App\Features\Products\Type\CreateProductType;
use App\Features\Products\Type\UpdateProductType;
use App\Repository\Orders\OrderRepository;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
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
    public function dashboard(Request $request, OrderRepository $orderRepository, int $productLimit = 100, int $categoryLimit = 100): Response
    {
        $command = new GetCategoriesAndProductsQuery($productLimit, $categoryLimit, null);
        $handler = $this->bus->dispatch($command);
        $result = GetEnvelopeResultService::invoke($handler);

        $allOrders = $orderRepository->findAllOrders();
        $totalOrdersCount = count($allOrders);
    
        // Pagination setup
        $limit = 8; // Number of items per page
        $currentPage = $request->query->getInt('page', 1);
        $offset = ($currentPage - 1) * $limit;

        // Fetch paginated orders
        $orders = $orderRepository->findOrdersWithPagination($limit, $offset);

        // Fetch total order count
        $totalOrders = $orderRepository->countOrders();
        $totalPages = ceil($totalOrders / $limit);

        return $this->render('admin/dashboard.html.twig', array_merge($result, [
            'orders' => $orders,
            'totalOrdersCount' => $totalOrdersCount,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]));
    }
    #[Route('/admin/products', name: 'admin_products', methods: ['GET', 'POST'])]
    public function products(Request $request, int $productLimit = 20, int $categoryLimit = 20, ?string $id = ''): Response
    {
        // Fetch products and categories
        $command = new GetCategoriesAndProductsQuery($productLimit, $categoryLimit, null);
        $handler = $this->bus->dispatch($command);
        $result = GetEnvelopeResultService::invoke($handler);

        // Create the forms
        $createProductCommand = new CreateProductCommand();
        $createForm = $this->createForm(CreateProductType::class, $createProductCommand);
        $createForm->handleRequest($request);

        $editProductCommand = new UpdateProductCommand($id);
        $editForm = $this->createForm(UpdateProductType::class, $editProductCommand);
        $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $editProductCommand->setImageFile($editForm->get('imageFile')->getData());
                $this->bus->dispatch($editProductCommand);
                return $this->redirectToRoute('admin_products');
            }

        // Handle form submissions
        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $createProductCommand->setImgFile($createForm->get('imgFile')->getData());
            $this->bus->dispatch($createProductCommand);
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/products.html.twig', array_merge($result, [
            'createForm' => $createForm->createView(),
            'editForm' => isset($editForm) ? $editForm->createView() : null,

        ]));
    }

    #[Route('/admin/products/edit', name: 'admin_products_edit', methods: ['GET', 'POST'])]
    public function editProduct(Request $request): Response
    {
        $editProductCommand = new UpdateProductCommand();
        $editForm = $this->createForm(UpdateProductType::class, $editProductCommand);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $editProductCommand->setImageFile($editForm->get('imageFile')->getData());
            $this->bus->dispatch($editProductCommand);
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/products.html.twig', [
            'editForm' => $editForm->createView(),
        ]);
    }

        
    #[Route('/admin/products/delete/{id}', name: 'admin_product_delete', methods: ['GET', 'POST'])]
    public function deleteProduct(string $id): Response
    {
        try {
            $deleteProductCommand = DeleteProductCommand::create($id);
            $this->bus->dispatch($deleteProductCommand);
            $this->addFlash('success', 'Product deleted successfully.');
        } catch (HandlerFailedException $e) {
            $this->addFlash('error', 'Failed to delete product: ' . $e->getMessage());
        }

        return $this->redirectToRoute('admin_products');
}


}