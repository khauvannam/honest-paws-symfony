<?php

namespace App\Features\Users\Command;

class ResetPasswordCommand
{
    private string $userId;
    private string $password;

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): ResetPasswordCommand
    {
        $this->userId = $userId;
        return $this;
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


    /**
     * @param string $userId
     * @param string $password
     */
    public function __construct(string $userId, string $password)
    {
        $this->userId = $userId;
        $this->password = $password;
    }


}