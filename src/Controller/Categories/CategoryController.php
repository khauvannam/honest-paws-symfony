<?php

namespace App\Controller\Categories;

use App\Features\Categories\Command\CreateCategoryCommand;
use App\Features\Categories\Command\CreateCategoryType;
use App\Features\Categories\Command\DeleteCategoryCommand;
use App\Features\Categories\Command\UpdateCategoryCommand;
use App\Features\Categories\Command\UpdateCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class CategoryController extends AbstractController
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    #[Route("/categories", name: "category_index", methods: ["GET"])]
    public function index(): Response
    {
        // Ideally, this should be handled by a query handler as well
        // For the sake of simplicity, we'll keep this example as is
        return $this->render("category/index.html.twig");
    }

    #[Route("/categories/new", name: "category_new", methods: ["GET", "POST"])]
    public function createAsync(Request $request): RedirectResponse|Response
    {
        $command = new CreateCategoryCommand("", "");
        $form = $this->createForm(CreateCategoryType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->bus->dispatch($command);
                return $this->redirectToRoute("category_success");
            } catch (ExceptionInterface $e) {
                // Handle the exception or display an error message
            }
        }

        return $this->render("category/new.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    #[Route("/categories/success", name: "category_success")]
    public function createSuccess(): Response
    {
        return $this->render("category/success.html.twig");
    }

    #[Route("/categories/{id}", name: "category_show", methods: ["GET"])]
    public function show(string $id): Response
    {
        // Ideally, this should be handled by a query handler
        return $this->render("category/show.html.twig");
    }

    #[Route("/categories/{id}/edit", name: "category_edit", methods: ["POST"])]
    public function editAsync(
        Request $request,
        string $id
    ): RedirectResponse|Response {
        $command = new UpdateCategoryCommand(Uuid::fromString($id), "", "");
        $form = $this->createForm(UpdateCategoryType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->bus->dispatch($command);
                return $this->redirectToRoute("category_success");
            } catch (ExceptionInterface $e) {
                // Handle the exception or display an error message
            }
        }

        return $this->render("category/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    #[
        Route(
            "/categories/{id}/delete",
            name: "category_delete",
            methods: ["POST"]
        )
    ]
    public function delete(string $id): RedirectResponse
    {
        $command = new DeleteCategoryCommand(Uuid::fromString($id));
        try {
            $this->bus->dispatch($command);
        } catch (ExceptionInterface $e) {
            // Handle the exception or display an error message
        }

        return $this->redirectToRoute("category_index");
    }
}
