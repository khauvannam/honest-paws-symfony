<?php

namespace App\Controller\Identities;

use App\Features\Users\Command\RegisterUserCommand;
use App\Features\Users\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IdentityController extends AbstractController
{

    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/register', name: 'register')]
    public function CreateAsync(Request $request): RedirectResponse|Response
    {
        $command = new RegisterUserCommand();
        $form = $this->createForm(RegisterType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->dispatch($command);
            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/insertEmail', name: 'insertEmail')]
    public function insertEmail(): Response
    {
        return $this->render('emails/insertEmail.html.twig');
    }
    #[Route('/resetPassword', name: 'resetPassword')]
    public function resetPassword(Request $request): Response
    {
        return $this->render('emails/resetPassword.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response

    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
