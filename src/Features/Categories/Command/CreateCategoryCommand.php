<?php

namespace App\Features\Categories\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateCategoryCommand
{
    private string $name;
    private string $description;
    private UploadedFile $uploadedFile;

    public function setDescription(string $description): CreateCategoryCommand
    {
        $this->description = $description;
        return $this;
    }

    public function setName(string $name): CreateCategoryCommand
    {
        $this->name = $name;
        return $this;
    }

    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }

    public function setUploadedFile(UploadedFile $uploadedFile): CreateCategoryCommand
    {
        $this->uploadedFile = $uploadedFile;
        return $this;
    }

    public function __construct()
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public static function create($name, $description, UploadedFile $uploadedFile): CreateCategoryCommand
    {
        $self = new self();
        $self->setName($name);
        $self->setDescription($description);
        $self->setUploadedFile($uploadedFile);
        return $self;
    }

}
