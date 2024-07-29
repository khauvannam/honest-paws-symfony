<?php

namespace App\Controller\Products;

use App\Entity\Products\ProductVariant;
use App\Features\Products\CreateProductVariantCommand;
use App\Features\Products\CreateProductVariantType;
use App\Repository\Products\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductVariantController extends AbstractController
{
    private MessageBusInterface $bus;
    private EntityManagerInterface $entityManager;
    private ProductRepository $productRepository;

    public function __construct(MessageBusInterface $bus, EntityManagerInterface $entityManager, ProductRepository $productRepository)
    {
        $this->bus = $bus;
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/products/{productId}/variants/new', name: 'product_variant_new', methods: ['GET', 'POST'])]
    public function createAsync(Request $request, string $productId): RedirectResponse|Response
    {
        $product = $this->productRepository->find($productId);
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }

        $command = CreateProductVariantCommand::create('', 0, 0.0, 0.0, $productId, $product);
        $form = $this->createForm(CreateProductVariantType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->dispatch($command);
            return $this->redirectToRoute('product_variant_success');
        }

        return $this->render('product_variant/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/variants/success', name: 'product_variant_success')]
    public function createSuccess(): Response
    {
        return $this->render('product_variant/success.html.twig');
    }

    #[Route('/products/{productId}/variants/{variantId}/edit', name: 'product_variant_edit', methods: ['GET', 'POST'])]
    public function editAsync(Request $request, string $productId, string $variantId): RedirectResponse|Response
    {
        $product = $this->productRepository->find($productId);
        if (!$product) {
            throw $this->createNotFoundException('The product does not exist');
        }

        $productVariant = $this->entityManager->getRepository(ProductVariant::class)->find($variantId);
        if (!$productVariant) {
            throw $this->createNotFoundException('The product variant does not exist');
        }

        $command = CreateProductVariantCommand::create(
            $productVariant->getVariantName(),
            $productVariant->getQuantity(),
            $productVariant->getOriginalPrice(),
            $productVariant->getDiscountedPrice(),
            $productId,
            $product
        );

        $form = $this->createForm(CreateProductVariantType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->dispatch($command);
            return $this->redirectToRoute('product_variant_success');
        }

        return $this->render('product_variant/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/{productId}/variants/{variantId}/delete', name: 'product_variant_delete', methods: ['POST'])]
    public function delete(Request $request, string $productId, string $variantId): RedirectResponse
    {
        $productVariant = $this->entityManager->getRepository(ProductVariant::class)->find($variantId);

        if (!$productVariant) {
            throw $this->createNotFoundException('The product variant does not exist');
        }

        if ($this->isCsrfTokenValid('delete' . $productVariant->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($productVariant);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('product_variant_index', ['productId' => $productId]);
    }
}
