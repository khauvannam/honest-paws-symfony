<?php
namespace App\Controller\ResetPassword;

use App\Features\Users\Type\ResetPasswordRequestType;
use App\Features\Users\Type\ResetPasswordType;
use App\Features\Tokens\Command\CreateTokenCommand;
use App\Features\Users\Command\ResetPasswordCommand;
use App\Entity\Users\CaseDescription;
use App\Features\Users\Command\ResetPasswordRequestCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset-password/request', name: 'reset_password_request', methods: ['GET', 'POST'])]
    public function request(Request $request, MessageBusInterface $bus): Response
    {
        $command = new ResetPasswordRequestCommand(''); 
        $form = $this->createForm(ResetPasswordRequestType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();

            $command = new CreateTokenCommand($email, CaseDescription::ResetPassword);
            $bus->dispatch($command);

            $this->addFlash('success', 'Password reset token sent to your email.');

            return $this->redirectToRoute('reset_password_request');
        }

        return $this->render('reset_password/request_reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reset-password/{token}', name: 'reset_password', methods: ['GET', 'POST'])]
    public function reset(string $token, Request $request, MessageBusInterface $bus): Response
    {
        $command = new ResetPasswordCommand('', '', $token);
        $form = $this->createForm(ResetPasswordType::class, ['token' => $token]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();
            $email = $request->query->get('email');

            $command = new ResetPasswordCommand($email, $newPassword, $token);
            $bus->dispatch($command);

            $this->addFlash('success', 'Password has been reset.');

            return $this->redirectToRoute('login'); 
        }

        return $this->render('reset_password/reset_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
