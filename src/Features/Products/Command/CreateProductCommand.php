<?php
namespace App\Features\Products\Command;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProductCommand
{
    private string $name;
    private string $description;
    private string $productUseGuide;
    private UploadedFile $imgFile;
    private string $discountPercent;

    public function __construct(
        string $name, 
        string $description, 
        string $productUseGuide, 
        UploadedFile $imgFile, 
        string $discountPercent, 
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imgFile = $imgFile;
        $this->discountPercent = $discountPercent;
    }

    public static function create(
        string $name, 
        string $description, 
        string $productUseGuide, 
        UploadedFile $imgFile, 
        string $discountPercent, 
    ): self {
        return new self($name, $description, $productUseGuide, $imgFile, $discountPercent);
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

    public function getImageFile(): UploadedFile
    {
        return $this->imgFile;
    }

    public function getDiscountPercent(): string
    {
        return $this->discountPercent;
    }

}
