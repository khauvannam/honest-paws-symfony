<?php

declare(strict_types=1);

namespace App\Controller\Comments;

use App\Features\Comments\Command\CreateCommentCommand;
use App\Features\Comments\Type\CreateCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    public function __construct(private MessageBusInterface $bus)
    {
    }

    #[Route('/comment/new/{productId}', name: 'comment_new')]
    public function new(Request $request, string $productId): Response
    {
        $command = new CreateCommentCommand();
        $form = $this->createForm(CreateCommentType::class, $command);
        $form->handleRequest($request);
        return $this->render('product/product_details.html.twig', ['id' => $productId]);
    }

}
