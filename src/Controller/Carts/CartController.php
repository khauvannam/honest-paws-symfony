<?php

namespace App\Controller\Carts;

use App\Features\Carts\Command\CartType;
use App\Features\Carts\Command\CreateCartCommand;
use App\Features\Carts\Command\DeleteCartCommand;
use App\Features\Carts\Command\UpdateCartCommand;
use App\Features\Carts\Query\GetCartQuery;
use App\Services\GetEnvelopeResultService;
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

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/cart/new', name: 'cart_new', methods: ['GET', 'POST'])]
    public function createAsync(Request $request): RedirectResponse|Response
    {
        $command = CreateCartCommand::create('');
        $form = $this->createForm(CartType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = $form->getData(); // Get updated data from the form
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

    /**
     * @throws ExceptionInterface
     */
    #[Route('/cart/{id}', name: 'cart_show', methods: ['GET'])]
    public function show(string $id, string $customerId): Response
    {
        // Create a query or a command to fetch the cart details
        $command = new GetCartQuery($id, $customerId); // Assuming a GetCartQuery exists
        $handler = $this->bus->dispatch($command);
        $cart = GetEnvelopeResultService::invoke($handler);

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
    #[Route('/cart/{id}/edit', name: 'cart_edit', methods: ['POST'])]
    public function editAsync(Request $request, string $customerId, string $id): RedirectResponse|Response
    {
        $command = UpdateCartCommand::create($id, $customerId, []); // Use an empty array or proper cart items if needed

        $form = $this->createForm(CartType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $command = UpdateCartCommand::create(
                $data->getId(),
                $data->getCustomerId(),
                $data->getCartItems() // Assuming this property holds cart items
            );

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
        $command = DeleteCartCommand::create($id, $customerId);
        try {
            $this->bus->dispatch($command);
        } catch (ExceptionInterface $e) {
            // Handle the exception as needed
        }
        return $this->redirectToRoute('cart_success');
    }
}
