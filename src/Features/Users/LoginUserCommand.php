<?php

namespace App\Features\Users;

use App\Repository\Identities\IdentityRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginUserCommand
{
    private function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    private string $email;
    private string $password;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function Create(string $email, string $password): self
    {
        return new self($email, $password);
    }


}

#[AsMessageHandler]
class LoginUserHandler
{
    private IdentityRepository $identityRepository;

    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(
        IdentityRepository          $identityRepository,
        Security                    $security,
        UserPasswordHasherInterface $passwordEncoder
    )
    {
        $this->identityRepository = $identityRepository;
        $this->security = $security;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(LoginUserCommand $command): void
    {
        $user = $this->identityRepository->findOneByEmail($command->getEmail());
        $this->identityRepository->loginUser($user);

        if (!$user || !$this->passwordEncoder->isPasswordValid($user, $command->getPassword())) {
            throw new AuthenticationException('Invalid credentials.');
        }

    }
}

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
            ])
            ->add('login', SubmitType::class, [
                'label' => 'Login',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LoginUserCommand::class,
        ]);
    }
}