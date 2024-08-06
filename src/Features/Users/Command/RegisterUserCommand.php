<?php

namespace App\Features\Users\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class RegisterUserCommand
{
    public function __construct()
    {
    }

    private string $username = '';

    private string $email = '';

    private string $password = '';
    private ?UploadedFile $imageFile = null;

    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    public function setImageFile(?UploadedFile $imageFile): RegisterUserCommand
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
