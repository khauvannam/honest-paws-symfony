<?php

namespace App\Controller;

use App\Entity\Products\Product;
use App\Features\Products\UpdateProductCommand;
use App\Features\Products\CreateProductCommand;
use App\Features\Products\CreateProductType;
use App\Features\Products\GetProductQuery;
use App\Features\Products\UpdateProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;

// Import ArrayCollection

class ProductController extends AbstractController
{
    private MessageBusInterface $bus;
    private EntityManagerInterface $entityManager;

    public function __construct(MessageBusInterface $bus, EntityManagerInterface $entityManager)
    {
        $this->bus = $bus;
        $this->entityManager = $entityManager;
    }

    #[Route('/products', name: 'product_index', methods: ['GET'])]
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/products/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function createAsync(Request $request): RedirectResponse|Response
    {
        $command = CreateProductCommand::create('', '', '', '', '', new \DateTime(), new \DateTime(), []);
        $form = $this->createForm(CreateProductType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = $form->getData(); // Get updated data from the form
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

    #[Route('/products/{id}', name: 'product_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

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

    #[Route('/products/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    public function editAsync(Request $request, int $id): RedirectResponse|Response
    {
        $product = CreateProductCommand::create('', '', '', '', '', new \DateTime(), new \DateTime(), []);

        $form = $this->createForm(UpdateProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Create an UpdateProductCommand with the form data
            $command = new UpdateProductCommand(
                $data->getId(),
                $data->getName(),
                $data->getDescription(),
                $data->getPrice(),
                $data->getCategory(),
                $data->getCreatedAt(),
                $data->getUpdatedAt(),
            );

            // Dispatch the command to update the product
            $this->bus->dispatch($command);

            // Redirect to the success page or product list
            return $this->redirectToRoute('product_success');
        }

        // Render the form view for editing
        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/{id}/delete', name: 'product_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): RedirectResponse
    {

        

        return $this->redirectToRoute('product_index');
    }
}
