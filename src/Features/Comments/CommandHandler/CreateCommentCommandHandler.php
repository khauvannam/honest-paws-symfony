<?php

namespace App\Features\Comments\CommandHandler;

use App\Entity\Comments\Comment;
use App\Features\Comments\Command\CreateCommentCommand;
use App\Repository\Comments\CommentRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateCommentCommandHandler
{
    public function __construct(private CommentRepository $commentRepository)
    {
    }

    public function __invoke(createCommentCommand $command): void
    {
        $comment = new Comment($command->getContent());
        $comment->setUserId($command->getUserId());
        $comment->setProductId($command->getProductId());
        $this->commentRepository->save($comment);
    }
}