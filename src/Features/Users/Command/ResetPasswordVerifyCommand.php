<?php

namespace App\Features\Users\Command;

use App\Entity\Users\CaseDescription;

class ResetPasswordVerifyCommand
{
    private string $email = '';
    private string $token = '';
    private CaseDescription $caseDescription = CaseDescription::ResetPassword;

    public function __construct()
    {
    }

    public function getCaseDescription(): CaseDescription
    {
        return $this->caseDescription;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): ResetPasswordVerifyCommand
    {
        $this->token = $token;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): ResetPasswordVerifyCommand
    {
        $this->email = $email;
        return $this;
    }

}