<?php

namespace App\Features\Comments\CommandHandler;

use App\Entity\Users\User;
use App\Features\Comments\Command\DeleteCommentCommand;
use App\Repository\Comments\CommentRepository;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;

class DeleteCommentCommandHandler
{
    public function __construct(private CommentRepository $repository, private Security $security)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(DeleteCommentCommand $command): void
    {
        /**
         * @var User $user
         */
        $user = $this->security->getUser();
        $comment = $this->repository->findOneBy(['id' => $command->getId()]);
        if ($user->getId() !== $comment->getUser()->getId()) {
            throw new Exception();
        }
        $this->repository->delete($comment);
    }
}