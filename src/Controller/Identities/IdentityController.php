<?php

namespace App\Controller\Identities;

use App\Features\Users\LoginType;
use App\Features\Users\LoginUserCommand;
use App\Features\Users\RegisterType;
use App\Features\Users\RegisterUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

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
        $command = RegisterUserCommand::create('', '', '');
        $form = $this->createForm(RegisterType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->dispatch($command);
            return $this->redirectToRoute('register_success');
        }

        return $this->render('register/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/register/success', name: 'register_success')]
    public function registerSuccess(): Response
    {
        return $this->render('register/success.html.twig');
    }
    #[Route('/login',name: 'login')]
    public function login(Request $request): Response
    {
        $command = LoginUserCommand::create('', '');
        $form = $this->createForm(LoginType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->bus->dispatch($command);
                // Redirect to the secured area
                return $this->redirectToRoute('home');
            } catch (AuthenticationException $e) {

                $this->addFlash('error', 'Invalid credentials.');
            } catch (ExceptionInterface $e) {
            }
        }

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}