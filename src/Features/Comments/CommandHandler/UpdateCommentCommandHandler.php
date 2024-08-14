<?php

namespace App\Features\Comments\CommandHandler;

use App\Features\Comments\Command\UpdateCommentCommand;
use App\Repository\Comments\CommentRepository;

class UpdateCommentCommandHandler
{

    public function __construct(private CommentRepository $commentRepository)
    {
    }

    public function __invoke(UpdateCommentCommand $command): void
    {
        $comment = $this->commentRepository->findOneBy(['id' => $command->getId()]);
        $comment->setContent($command->getContent());
        $this->commentRepository->save($comment);
    }
}