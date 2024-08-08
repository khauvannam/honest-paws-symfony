<?php

namespace App\Features\Products\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateProductCommand
{
    private string $name = '';
    private string $description = '';
    private string $productUseGuide = '';
    private ?UploadedFile $imgFile = null;
    private string $categoryId = '';
    private float $price = 0;

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): CreateProductCommand
    {
        $this->price = $price;
        return $this;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function setCategoryId(string $categoryId): CreateProductCommand
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    private string $discountPercent;

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

    public function getProductUseGuide(): string
    {
        return $this->productUseGuide;
    }

    public function getImgFile(): ?UploadedFile
    {
        return $this->imgFile;
    }

    public function setName(string $name): CreateProductCommand
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): CreateProductCommand
    {
        $this->description = $description;
        return $this;
    }

    public function setProductUseGuide(string $productUseGuide): CreateProductCommand
    {
        $this->productUseGuide = $productUseGuide;
        return $this;
    }

    public function setImgFile(?UploadedFile $imgFile): CreateProductCommand
    {
        $this->imgFile = $imgFile;
        return $this;
    }

    public function setDiscountPercent(string $discountPercent): CreateProductCommand
    {
        $this->discountPercent = $discountPercent;
        return $this;
    }

    public function getDiscountPercent(): string
    {
        return $this->discountPercent;
    }

}
