<?php

namespace App\Features\Users\CommandHandler;

use App\Entity\Users\User;
use App\Features\Users\Command\RegisterUserCommand;
use App\Repository\Identities\IdentityRepository;
use App\Services\BlobService;
use App\Services\MailerService;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsMessageHandler]
class RegisterUserCommandHandler
{
    private IdentityRepository $identityRepository;
    private UserPasswordHasherInterface $userPasswordHasher;
    private MailerService $mailSuccess;
    private BlobService $blobService;

    public function __construct(
        IdentityRepository          $identityRepository,
        UserPasswordHasherInterface $userPasswordHasher,
        MailerService               $mailSuccess,
        BlobService                 $blobService
    )
    {
        $this->identityRepository = $identityRepository;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->mailSuccess = $mailSuccess;
        $this->blobService = $blobService;
    }


    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(RegisterUserCommand $command): void
    {
        $plainTextPassword = $command->getPassword();
        $user = User::Create($command->getUsername(), $command->getEmail());
        $hashPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $plainTextPassword
        );
        $fileName = $command->getImageFile() ? $this->blobService->upload($command->getImageFile()) : '';
        $user->setPassword($hashPassword);
        $user->setAvatarLink($fileName);
        $this->mailSuccess->sendRegistrationEmail($user->getEmail(), $user->getUsername(), $user->getId());
        $this->identityRepository->createAsync($user);
    }
}
