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

    public function __construct(string $id, string $name, string $description, string $productUseGuide, ?UploadedFile $imageFile, string $discountPercent, DateTime $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imageFile = $imageFile;
        $this->discountPercent = $discountPercent;
        $this->updatedAt = $updatedAt;
    }

    public static function create(int $id, string $name, string $description, string $productUseGuide, ?UploadedFile $imageFile, string $discountPercent, DateTime $updatedAt): self
    {
        return new self($id, $name, $description, $productUseGuide, $imageFile, $discountPercent, $updatedAt);
    }

    public function getId(): int
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

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}

class UpdateProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class, [
                'label' => 'ID',
                'disabled' => true,
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('productUseGuide', TextType::class, [
                'label' => 'Product Use Guide',
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image URL',
            ])
            ->add('discountPercent', TextType::class, [
                'label' => 'Discount Percent',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Update',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateProductCommand::class,
        ]);
    }
}
