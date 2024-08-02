<?php

namespace App\Controller\Carts;


use App\Features\Carts\Command\CartType;
use App\Features\Carts\Command\CreateCartCommand;
use App\Repository\Carts\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private MessageBusInterface $bus;
    private CartRepository $cartRepository;

    public function __construct(MessageBusInterface $bus, CartRepository $cartRepository)
    {
        $this->bus = $bus;
        $this->cartRepository = $cartRepository;
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
    public function show(string $id, string $customerId): Response
    {
        $cart = $this->cartRepository->findByIdAndCustomerId($id, $customerId);

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
    public function editAsync(Request $request, string $customerId, string $id): RedirectResponse|Response
    {
        $cart = $this->cartRepository->findByIdAndCustomerId($id, $customerId);

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
    public function delete(Request $request, string $customerId, string $id): RedirectResponse
    {
        $cart = $this->cartRepository->findByIdAndCustomerId($id, $customerId);

        if (!$cart) {
            throw $this->createNotFoundException('The cart does not exist');
        }

        $this->cartRepository->delete($cart);
        return $this->redirectToRoute('cart_index');
    }
}
