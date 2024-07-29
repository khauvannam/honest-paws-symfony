<?php

namespace App\Features\Products;

use App\Entity\Products\Product;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProductCommand
{
    private string $name;
    private string $description;
    private string $productUseGuide;
    private string $imageUrl;
    private string $discountPercent;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(string $name, string $description, string $productUseGuide, string $imageUrl, string $discountPercent, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imageUrl = $imageUrl;
        $this->discountPercent = $discountPercent;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function create(string $name, string $description, string $productUseGuide, string $imageUrl, string $discountPercent, DateTime $createdAt, DateTime $updatedAt): self
    {
        return new self($name, $description, $productUseGuide, $imageUrl, $discountPercent, $createdAt, $updatedAt);
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

    public function getImageUrl(): string
    {
        return $this->imageUrl;
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
}

#[AsMessageHandler]
class ProductCommandHandler
{
    private ProductRepository $productRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(AddProductCommand $command): void
    {
        $product = Product::create(
            $command->getName(),
            $command->getDescription(),
            $command->getProductUseGuide(),
            $command->getImageUrl(),
            $command->getDiscountPercent(),
            $command->getCreatedAt(),
            $command->getUpdatedAt()
        );

        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}

class ProductType extends AbstractType
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
            ->add('imageUrl', TextType::class, [
                'label' => 'Image URL',
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
            'data_class' => AddProductCommand::class,
        ]);
    }
}
?>
