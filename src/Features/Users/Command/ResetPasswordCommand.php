<?php

namespace App\Features\Users\Command;

class ResetPasswordCommand
{
    private string $email;
    private string $newPassword;
    private string $token;

    public function __construct(string $email, string $newPassword, string $token)
    {
        $this->email = $email;
        $this->newPassword = $newPassword;
        $this->token = $token;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
