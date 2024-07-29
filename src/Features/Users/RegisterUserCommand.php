<?php

namespace App\Features\Users;

use App\Entity\Users\User;
use App\Repository\Identities\IdentityRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserCommand
{
    private function __construct(string $username, string $email, string $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    private string $username;

    private string $email;

    private string $password;

    public static function Create(string $username, string $email, string $password): self
    {
        return new self($username, $email, $password);
    }

    public function getPassword(): string
    {
        return $this->password;
    }


    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}

#[AsMessageHandler]
class RegisterUserHandler
{
    private IdentityRepository $identityRepository;

    public function __construct(IdentityRepository $identityRepository)
    {
        $this->identityRepository = $identityRepository;

    }

    public function __invoke(RegisterUserCommand $command, UserPasswordHasherInterface $userPasswordHasher): void
    {
        $plainTextPassword = $command->getPassword();
        $user = User::Create($command->getUsername(), $command->getUserIdentifier());
        $hashPassword = $userPasswordHasher->hashPassword($user, $plainTextPassword);
        $user->setPassword($hashPassword);
        $this->identityRepository->createAsync($user);
    }
}


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
            ])
            ->add('register', SubmitType::class, [
                'label' => 'Register',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegisterUserCommand::class,
        ]);
    }
}