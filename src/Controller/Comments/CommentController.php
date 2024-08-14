<?php

declare(strict_types=1);

namespace App\Controller\Comments;

use App\Entity\Users\User;
use App\Features\Comments\Command\CreateCommentCommand;
use App\Features\Comments\Command\UpdateCommentCommand;
use App\Features\Comments\Type\CreateCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/comment/new/{productId}', name: 'comment_new', methods: ['POST', 'GET'])]
    public function new(Request $request, string $productId): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $command = new CreateCommentCommand();
        $form = $this->createForm(CreateCommentType::class, $command);

        $form->handleRequest($request);
        $command->setProductId($productId);
        $command->setUserId($user->getId());
        $this->bus->dispatch($command);
        return $this->render('product/product_details.html.twig', ['id' => $productId]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/comment/edit/{productId}', name: 'comment_edit', methods: ['POST', 'GET'])]
    public function edit(Request $request, string $productId): Response
    {
        $command = new UpdateCommentCommand();
        $form = $this->createForm(UpdateCommentCommand::class, $command);

        $form->handleRequest($request);
        $this->bus->dispatch($command);
        return $this->render('product/product_details.html.twig', ['id' => $productId]);
    }

}
