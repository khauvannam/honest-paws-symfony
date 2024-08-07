<?php
// src/Features/Users/Command/ResetPasswordRequestCommand.php

namespace App\Features\Users\Command;

class ResetPasswordRequestCommand
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
