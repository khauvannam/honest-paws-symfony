<?php

namespace App\Controller\Products;

use App\Features\Products\Command\CreateProductCommand;
use App\Features\Products\Command\DeleteProductCommand;
use App\Features\Products\Command\UpdateProductCommand;
use App\Features\Products\Query\GetProductQuery;
use App\Features\Products\Query\ListProductQuery;
use App\Features\Products\Type\CreateProductType;
use App\Features\Products\Type\UpdateProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;


// Import ArrayCollection

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
    #[Route('/products/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function createAsync(Request $request): RedirectResponse|Response
    {
        $imgFile = new UploadedFile('', '', '', 1);
        $command = new CreateProductCommand('', '', '', $imgFile, 0);
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

    #[Route('/products/{id}', name: 'product_show', methods: ['GET'])]
    public function show(string $id): Response
    {
        $command = new GetProductQuery($id);
        $product = $this->bus->dispatch($command);

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
    public function editAsync(Request $request): RedirectResponse|Response
    {
        $product = UpdateProductCommand::create('', '', '', '', null, '' );

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
        $command = DeleteProductCommand::create($id);
        try {
            $this->bus->dispatch($command);
        } catch (ExceptionInterface $e) {
        }
        return $this->redirectToRoute('product_index');
    }
}
