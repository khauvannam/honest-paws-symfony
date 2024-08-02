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
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private ArrayCollection $productVariants;

    public function __construct(
        string $name, 
        string $description, 
        string $productUseGuide, 
        UploadedFile $imgFile, 
        string $discountPercent, 
        DateTime $createdAt, 
        DateTime $updatedAt, 
        ArrayCollection $productVariants
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imgFile = $imgFile;
        $this->discountPercent = $discountPercent;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->productVariants = $productVariants;
    }

    public static function create(
        string $name, 
        string $description, 
        string $productUseGuide, 
        UploadedFile $imgFile, 
        string $discountPercent, 
        DateTime $createdAt, 
        DateTime $updatedAt, 
        array $productVariants
    ): self {
        return new self($name, $description, $productUseGuide, $imgFile, $discountPercent, $createdAt, $updatedAt, new ArrayCollection($productVariants));
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getProductVariants(): ArrayCollection
    {
        return $this->productVariants;
    }
}

class CreateProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                'label' => 'Image (JPEG, PNG file)',
                'mapped' => false,
                'required' => true,
            ])
            ->add('discountPercent', TextType::class, [
                'label' => 'Discount Percent',
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Created At',
            ])
            ->add('updatedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Updated At',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateProductCommand::class,
        ]);
    }
}
