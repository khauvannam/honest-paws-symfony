<?php

namespace App\Features\Tokens\Query;

use App\Entity\Users\CaseDescription;

class CheckValidTokenQuery
{
    private string $userId;
    private string $token;
    private CaseDescription $caseDescription;

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): CheckValidTokenQuery
    {
        $this->userId = $userId;
        return $this;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): CheckValidTokenQuery
    {
        $this->token = $token;
        return $this;
    }

    public function getCaseDescription(): CaseDescription
    {
        return $this->caseDescription;
    }

    public function setCaseDescription(CaseDescription $caseDescription): CheckValidTokenQuery
    {
        $this->caseDescription = $caseDescription;
        return $this;
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
    }

}