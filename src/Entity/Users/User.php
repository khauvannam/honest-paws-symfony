<?php

namespace App\Entity\Users;

use App\Repository\IdentityRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: IdentityRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(string $username, string $email, string $passwordHash)
    {
        $this->id = Uuid::v4();
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }


    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "UUID")]
    #[ORM\Column]
    private string $id;
    #[ORM\Column(type: 'string', length: 180)]
    private string $username;
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;
    #[ORM\Column(type: 'string', length: 180)]
    private string $passwordHash;
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public static function Create(string $username, string $email, string $passwordHash): self
    {
        return new self($username, $email, $passwordHash);
    }

    public function getPassword(): string
    {
        return $this->passwordHash;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
