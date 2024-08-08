<?php

namespace App\Features\Products\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateProductCommand
{
    private string $id;
    private string $name = '';
    private string $description = '';
    private string $productUseGuide = '';
    private ?UploadedFile $imageFile = null;
    private string $discountPercent = '';
    private float $price = 0;

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): UpdateProductCommand
    {
        $this->price = $price;
        return $this;
    }

    public function __construct(
        string $id
    )
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

    public function getProductUseGuide(): string
    {
        return $this->productUseGuide;
    }

    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    public function getDiscountPercent(): string
    {
        return $this->discountPercent;
    }

    public function setId(string $id): UpdateProductCommand
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): UpdateProductCommand
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): UpdateProductCommand
    {
        $this->description = $description;
        return $this;
    }

    public function setProductUseGuide(string $productUseGuide): UpdateProductCommand
    {
        $this->productUseGuide = $productUseGuide;
        return $this;
    }

    public function setImageFile(?UploadedFile $imageFile): UpdateProductCommand
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function setDiscountPercent(string $discountPercent): UpdateProductCommand
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }
}
