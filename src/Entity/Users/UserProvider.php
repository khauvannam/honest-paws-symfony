<?php

namespace App\Entity\Users;

use App\Repository\Identities\UserProviderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProviderRepository::class)]
class UserProvider
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $userId;
    #[ORM\Id]
    #[ORM\Column]
    private CaseDescription $caseDescription;
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $token;
    private \DateTime $createdAt;

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string $userId
     * @param CaseDescription $caseDescription
     * @param string $token
     */
    public function __construct(string $userId, CaseDescription $caseDescription, string $token)
    {
        $this->userId = $userId;
        $this->caseDescription = $caseDescription;
        $this->token = $token;
        $this->createdAt = new \DateTime();

    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): UserProvider
    {
        $this->userId = $userId;
        return $this;
    }

    public function getCaseDescription(): CaseDescription
    {
        return $this->caseDescription;
    }

    public function setCaseDescription(CaseDescription $caseDescription): UserProvider
    {
        $this->caseDescription = $caseDescription;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): UserProvider
    {
        $this->token = $token;
        return $this;
    }

    public static function create($userId, $caseDescription, $token): self
    {
        return new self($userId, $caseDescription, $token);
    }

}

