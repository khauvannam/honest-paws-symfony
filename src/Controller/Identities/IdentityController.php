<?php

namespace App\Controller\Identities;

use App\Features\Users\Command\ChangePasswordCommand;
use App\Features\Users\Command\RegisterUserCommand;
use App\Features\Users\Command\ResetPasswordCommand;
use App\Features\Users\Command\ResetPasswordRequestCommand;
use App\Features\Users\Command\ResetPasswordVerifyCommand;
use App\Features\Users\Command\VerifyUserCommand;
use App\Features\Users\Type\ChangePasswordType;
use App\Features\Users\Type\RegisterType;
use App\Features\Users\Type\ResetPasswordRequestType;
use App\Features\Users\Type\ResetPasswordType;
use App\Features\Users\Type\ResetPasswordVerifyType;
use App\Services\GetEnvelopeResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
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
    public function CreateAsync(Request $request, Security $security): RedirectResponse|Response
    {
        if ($security->getUser()) {
            return $this->redirectToRoute('home');
        }
        $command = new RegisterUserCommand();
        $form = $this->createForm(RegisterType::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command->setImageFile($form->get('imageFile')->getData());
            $this->bus->dispatch($command);
            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/reset-password/request', name: 'reset_password_request')]
    public function resetPasswordRequest(Request $request): Response
    {
        $command = new ResetPasswordRequestCommand();
        $form = $this->createForm(ResetPasswordRequestType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->dispatch($command);
            return $this->redirectToRoute('reset_password_verify', ['email' => $command->getEmail()]);
        }
        return $this->render('security/reset-password-request.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/reset-password/verify/', name: 'reset_password_verify')]
    public function resetPasswordVerify(Request $request, #[MapQueryParameter] string $email): Response
    {
        $command = new ResetPasswordVerifyCommand();
        $form = $this->createForm(ResetPasswordVerifyType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command->setEmail($email);
            $this->bus->dispatch($command);
            return $this->redirectToRoute('reset_password', ['email' => $command->getEmail()]);
        }
        return $this->render('security/reset-password-verify.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/reset-password/', name: 'reset_password')]
    public function resetPassword(Request $request, #[MapQueryParameter] string $email): Response
    {
        $command = new ResetPasswordCommand();
        $form = $this->createForm(ResetPasswordType::class, $command);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $command->setEmail($email);
            $this->bus->dispatch($command);
            return $this->redirectToRoute('login'); 
        }
        return $this->render('security/reset-password.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security): Response|RedirectResponse
    {
        if ($security->getUser()) {
            return $this->redirectToRoute('home');
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/verify/{userId}', name: 'verify')]
    public function verify(?string $userId, Security $security): Response
    {
        if ($security->getUser()) {
            return $this->redirectToRoute('home');
        }
        $command = new VerifyUserCommand($userId);
        $result = $this->bus->dispatch($command);
        $verify = GetEnvelopeResultService::invoke($result);
        return $this->render('/security/verify_success.html.twig', ['verify' => $verify]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/change-password/{userId}', name: 'changePassword')]
    public function changePassword(Request $request, string $userId, Security $security): Response|RedirectResponse
    {
        if (!$security->getUser()) {
            throw new UserNotFoundException();
        }
        $form = $this->createForm(changePasswordType::class, $command = new ChangePasswordCommand($userId));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->bus->dispatch($command);
            return $this->redirectToRoute('login');
        }
        return $this->render('security/change_password.html.twig', ['form' => $form->createView()]);
    }
}
