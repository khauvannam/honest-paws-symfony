<?php

namespace App\Features\Users\Command;

class RegisterUserCommand
{
    public function __construct()
    {
    }

    private string $username = '';

    private string $email = '';

    private string $password = '';

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
