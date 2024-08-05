<?php

namespace App\Features\Categories\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateCategoryCommand
{
    private string $id;
    private string $name = '';
    private string $description = '';
    private ?UploadedFile $imageFile = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    public function setId(string $id): UpdateCategoryCommand
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): UpdateCategoryCommand
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): UpdateCategoryCommand
    {
        $this->description = $description;
        return $this;
    }

    public function setImageFile(?UploadedFile $imageFile): UpdateCategoryCommand
    {
        $this->imageFile = $imageFile;
        return $this;
    }
}
