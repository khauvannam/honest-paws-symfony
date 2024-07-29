<?php

namespace App\Features\Users;

class LoginUserCommand
{
    private function __construct(string $email, string $passwordHash)
    {
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    private string $email;
    private string $password;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public static function Create(string $email, string $password): self
    {
        return new self($email, $password);
    }
}
