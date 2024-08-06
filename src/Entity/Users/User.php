<?php

namespace App\Entity\Users;

use App\Repository\Identities\IdentityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: IdentityRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(string $username, string $email)
    {
        $this->id = Uuid::v4()->toString();
        $this->username = $username;
        $this->email = $email;
    }

    #[ORM\Id]
    #[ORM\Column]
    private string $id;
    #[ORM\Column(type: "string", length: 180)]
    private string $username;
    #[ORM\Column(type: "string", length: 180, unique: true)]
    private string $email;
    #[ORM\Column(type: "string", length: 180)]
    private string $passwordHash;
    #[ORM\OneToMany(targetEntity: UserProvider::class, mappedBy: "user", cascade: ["persist", "remove"])]
    private Collection $userProviders;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }
    #[ORM\Column(type: "json")]
    private array $roles = [];

    public static function Create(string $username, string $email): self
    {
        return new self($username, $email);
    }

    public function getPassword(): string
    {
        return $this->passwordHash;
    }

    public function setPassword($passwordHash): string
    {
        return $this->passwordHash = $passwordHash;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = "ROLE_USER";

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
