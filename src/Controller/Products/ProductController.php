<?php

namespace App\Controller\Products;


// Import ArrayCollection

use App\Features\Carts\Command\CreateCartItemCommand;
use App\Features\Carts\Type\CreateCartItemType;
use App\Features\Homes\Query\GetCategoriesAndProductsQuery;
use App\Features\Products\Command\CreateProductCommand;
use App\Features\Products\Command\DeleteProductCommand;
use App\Features\Products\Command\UpdateProductCommand;
use App\Features\Products\Query\GetProductCategoryId;
use App\Features\Products\Query\GetProductQuery;
use App\Features\Products\Type\CreateProductType;
use App\Features\Products\Type\UpdateProductType;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @throws ExceptionInterface
     */

    // #[IsGranted('ROLE_ADMIN', message: 'You need admin permission to access this page')]
    #[Route('/product/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function createAsync(Request $request): RedirectResponse|Response
    {
        $command = new CreateProductCommand();
        $form = $this->createForm(CreateProductType::class, $command);
        $form->handleRequest($request);
        $command->setImgFile($form->get('imgFile')->getData());
        if ($form->isSubmitted() && $form->isValid()) {

            $this->bus->dispatch($command);

            return $this->redirectToRoute('product_success');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // #[IsGranted('ROLE_ADMIN', message: 'You need admin permission to access this page')]
    #[Route('/products/success', name: 'product_success')]
    public function createSuccess(): Response
    {
        return $this->render('product/success.html.twig');
    }

    /**
     * @throws ExceptionInterface
     */

    // #[IsGranted('ROLE_ADMIN', message: 'You need admin permission to access this page')]
    #[Route('/products/edit/{id}', name: 'product_edit', methods: ['GET', 'POST'])]
    public function editAsync(Request $request, string $id): RedirectResponse|Response
    {
        $product = new UpdateProductCommand($id);

        $form = $this->createForm(UpdateProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Dispatch the command to update the product
            $this->bus->dispatch($product);

            // Redirect to the success page or product list
            return $this->redirectToRoute('product_success');
        }

        // Render the form view for editing
        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // #[IsGranted('ROLE_ADMIN', message: 'You need admin permission to access this page')]
    #[Route('/products/delete/{id}', name: 'product_delete', methods: ['POST'])]
    public function delete(string $id): RedirectResponse
    {
        $command = DeleteProductCommand::create($id);
        try {
            $this->bus->dispatch($command);
        } catch (ExceptionInterface $e) {
        }
        return $this->redirectToRoute('product_success');
    }

    /**
     * @throws ExceptionInterface
     */

    #[Route('/all-products', name: 'all_products', methods: ['GET'])]
    public function AllProducts(#[MapQueryParameter] int $productLimit = 20, #[MapQueryParameter] int $categoryLimit = 20, #[MapQueryParameter] string $search = null): Response
    {
        $command = new GetCategoriesAndProductsQuery($productLimit, $categoryLimit, $search);
        $handler = $this->bus->dispatch($command);
        $cartItemCommand = new CreateCartItemCommand();
        $form = $this->createForm(CreateCartItemType::class, $cartItemCommand);
        $result = GetEnvelopeResultService::invoke($handler);
        $result['cartForm'] = $form->createView();
        return $this->render('product/all_products.html.twig', $result);
    }

    /**
     * @throws ExceptionInterface
     */

    #[Route('/category-products/{id}', name: 'category_by_id', methods: ['GET'])]
    public function ProductByCategoryId(string $id): Response
    {
        $command = new GetProductCategoryId($id);
        $handler = $this->bus->dispatch($command);
        $cartItemCommand = new CreateCartItemCommand();
        $form = $this->createForm(CreateCartItemType::class, $cartItemCommand);
        $result = GetEnvelopeResultService::invoke($handler);
        $result['cartForm'] = $form->createView();
        return $this->render('product/category_by_id.html.twig', $result);

    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/product_details/{id}', name: 'product_details', methods: ['GET'])]
    public function GetProductId(string $id): Response
    {
        $command = new GetProductQuery($id);
        $cartItemCommand = new CreateCartItemCommand();
        $form = $this->createForm(CreateCartItemType::class, $cartItemCommand);

        $handler = $this->bus->dispatch($command);
        $result = GetEnvelopeResultService::invoke($handler);
        $result['id'] = $id;
        $result['cartForm'] = $form->createView();
        return $this->render('product/product_details.html.twig', $result);
    }
}
