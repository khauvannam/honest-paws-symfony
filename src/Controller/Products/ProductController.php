<?php

namespace App\Controller\Products;


// Import ArrayCollection

use App\Features\Products\Command\CreateProductCommand;
use App\Features\Products\Command\DeleteProductCommand;
use App\Features\Products\Command\UpdateProductCommand;
use App\Features\Products\Query\GetProductQuery;
use App\Features\Products\Query\ListProductQuery;
use App\Features\Products\Type\CreateProductType;
use App\Features\Products\Type\UpdateProductType;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    #[Route('/products', name: 'product_index', methods: ['GET'])]
    public function index(int $limit, int $offset): Response
    {
        $command = new ListProductQuery($limit, $offset);
        $products = $this->bus->dispatch($command);
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
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

    #[Route('/products/success', name: 'product_success')]
    public function createSuccess(): Response
    {
        return $this->render('product/success.html.twig');
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('product/show/{id}', name: 'product_show', methods: ['GET'])]
    public function show(string $id): Response
    {
        $command = new GetProductQuery($id);
        $result = $this->bus->dispatch($command);
        $product = GetEnvelopeResultService::invoke($result);

        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @throws ExceptionInterface
     */

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
}
