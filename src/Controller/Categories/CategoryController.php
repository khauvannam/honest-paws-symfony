<?php

namespace App\Controller\Categories;

use App\Features\Categories\Command\CreateCategoryCommand;
use App\Features\Categories\Command\DeleteCategoryCommand;
use App\Features\Categories\Command\UpdateCategoryCommand;
use App\Features\Categories\Query\GetAllCategoryQuery;
use App\Features\Categories\Type\CreateCategoryType;
use App\Features\Categories\Type\UpdateCategoryType;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    private MessageBusInterface $bus;
    private GetEnvelopeResultService $envelopeResultService;

    public function __construct(MessageBusInterface $bus, GetEnvelopeResultService $envelopeResultService)
    {
        $this->bus = $bus;
        $this->envelopeResultService = $envelopeResultService;
    }

    #[Route("/categories/new", name: "category_new", methods: ["GET", "POST"])]
    public function create(Request $request): RedirectResponse|Response
    {
        $command = new CreateCategoryCommand();
        $form = $this->createForm(CreateCategoryType::class, $command);
        $form->handleRequest($request);
        $command->setUploadedFile($form->get('uploadedFile')->getData());

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

    /**
     * @throws ExceptionInterface
     */
    //    #[Route("/categories", methods: ["GET"])]
    public function showAll(): Response
    {
        $query = new GetAllCategoryQuery();
        $handler = $this->bus->dispatch($query);
        $categories = GetEnvelopeResultService::invoke($handler);
        return $this->render("category/show.html.twig", [
            'categories' => $categories,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route("/categories/edit/{id}", name: "category_edit", methods: ["GET", "POST"])]
    public function edit(
        Request $request,
        string  $id
    ): RedirectResponse|Response {
        $command = new UpdateCategoryCommand($id);
        $form = $this->createForm(UpdateCategoryType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->bus->dispatch($command);

                return $this->redirectToRoute("category_success");
            } catch (ExceptionInterface $e) {
                throw new \Exception($e->getMessage());
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
        $command = new DeleteCategoryCommand($id);
        try {
            $this->bus->dispatch($command);
        } catch (ExceptionInterface $e) {
            throw new Exception($e);
        }

        return $this->redirectToRoute("category_index");
    }
}
