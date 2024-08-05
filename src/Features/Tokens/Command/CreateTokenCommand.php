<?php

namespace App\Features\Tokens\Command;

use App\Entity\Users\CaseDescription;

class CreateTokenCommand
{
    private string $email;
    private CaseDescription $caseDescription;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): CreateTokenCommand
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $email
     * @param CaseDescription $caseDescription
     */
    public function __construct(string $email, CaseDescription $caseDescription)
    {
        $this->email = $email;
        $this->caseDescription = $caseDescription;
    }

    public function getCaseDescription(): CaseDescription
    {
        return $this->caseDescription;
    }

    public function setCaseDescription(CaseDescription $caseDescription): void
    {
        $this->caseDescription = $caseDescription;
    }
}