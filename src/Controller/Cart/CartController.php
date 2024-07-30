<?php

namespace App\Controller\Cart;

use App\Entity\Carts\Cart;
use App\Features\Carts\Commands\Commands\Commands\Commands\CreateCartCommand;
use App\Features\Carts\Commands\Commands\Commands\Commands\CartType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private MessageBusInterface $bus;
    private EntityManagerInterface $entityManager;

    public function __construct(MessageBusInterface $bus, EntityManagerInterface $entityManager)
    {
        $this->bus = $bus;
        $this->entityManager = $entityManager;
    }

    #[Route('/cart', name: 'cart_index', methods: ['GET'])]
    public function index(): Response
    {
        $carts = $this->entityManager->getRepository(Cart::class)->findAll();

        return $this->render('cart/index.html.twig', [
            'carts' => $carts,
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/cart/new', name: 'cart_new', methods: ['GET', 'POST'])]
    public function createAsync(Request $request): RedirectResponse|Response
    {
        $command = CreateCartCommand::Create('');
        $form = $this->createForm(CartType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->dispatch($command);
            return $this->redirectToRoute('cart_success');
        }

        return $this->render('cart/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cart/success', name: 'cart_success')]
    public function createSuccess(): Response
    {
        return $this->render('cart/success.html.twig');
    }

    #[Route('/cart/{id}', name: 'cart_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $cart = $this->entityManager->getRepository(Cart::class)->find($id);

        if (!$cart) {
            throw $this->createNotFoundException('The cart does not exist');
        }

        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/cart/{id}/edit', name: 'cart_edit', methods: ['GET', 'POST'])]
    public function editAsync(Request $request, int $id): RedirectResponse|Response
    {
        $cart = $this->entityManager->getRepository(Cart::class)->find($id);

        if (!$cart) {
            throw $this->createNotFoundException('The cart does not exist');
        }

        $command = CreateCartCommand::Create($cart->getCustomerId());

        $form = $this->createForm(CartType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->dispatch($command);
            return $this->redirectToRoute('cart_success');
        }

        return $this->render('cart/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cart/{id}/delete', name: 'cart_delete', methods: ['POST'])]
    public function delete(Request $request, int $id): RedirectResponse
    {
        $cart = $this->entityManager->getRepository(Cart::class)->find($id);

        if (!$cart) {
            throw $this->createNotFoundException('The cart does not exist');
        }

        if ($this->isCsrfTokenValid('delete' . $cart->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($cart);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('cart_index');
    }
}
