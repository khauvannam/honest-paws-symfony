<?php

namespace App\Features\Users\Command;

class VerifyUserCommand
{
    private string $userId;

    /**
     * @param string $userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): VerifyUserCommand
    {
        $this->userId = $userId;
        return $this;
    }
}