<?php

namespace App\Features\Users\Command;

class ResetPasswordCommand
{
    private string $email = '';
    private string $password = '';

    public function __construct()
    {
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): ResetPasswordCommand
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

}