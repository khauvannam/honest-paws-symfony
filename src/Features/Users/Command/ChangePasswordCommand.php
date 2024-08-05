<?php

namespace App\Features\Users\Command;

class ChangePasswordCommand
{
    private string $userId;
    private string $newPassword;
    private string $password;

    /**
     * @param string $userId
     * @param string $newPassword
     * @param string $password
     */
    public function __construct(string $userId, string $newPassword, string $password)
    {
        $this->userId = $userId;
        $this->newPassword = $newPassword;
        $this->password = $password;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): ChangePasswordCommand
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): ChangePasswordCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): ChangePasswordCommand
    {
        $this->password = $password;
        return $this;
    }

}