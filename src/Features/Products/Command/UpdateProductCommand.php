<?php

namespace App\Features\Products\Command;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateProductCommand
{
    private string $id;
    private string $name;
    private string $description;
    private string $productUseGuide;
    private ?UploadedFile $imageFile;
    private string $discountPercent;
    private DateTime $updatedAt;

    public function __construct(string $id, string $name, string $description, string $productUseGuide, ?UploadedFile $imageFile, string $discountPercent)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imageFile = $imageFile;
        $this->discountPercent = $discountPercent;
    }

    public static function create(int $id, string $name, string $description, string $productUseGuide, ?UploadedFile $imageFile, string $discountPercent): self
    {
        return new self($id, $name, $description, $productUseGuide, $imageFile, $discountPercent);
    }

    public function getId():string
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

}
