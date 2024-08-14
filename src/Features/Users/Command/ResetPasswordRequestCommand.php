<?php

namespace App\Features\Users\Command;

use App\Entity\Users\CaseDescription;

class ResetPasswordRequestCommand
{
    private string $email = '';
    private CaseDescription $caseDescription = CaseDescription::ResetPassword;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getCaseDescription(): CaseDescription
    {
        return $this->caseDescription;
    }

    public function setEmail(string $email): ResetPasswordRequestCommand
    {
        $this->email = $email;
        return $this;
    }

}