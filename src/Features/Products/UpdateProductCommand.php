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

class UpdateProductCommand
{
    private int $id;
    private string $name;
    private string $description;
    private string $productUseGuide;
    private string $imageUrl;
    private string $discountPercent;
    private DateTime $updatedAt;

    public function __construct(int $id, string $name, string $description, string $productUseGuide, string $imageUrl, string $discountPercent, DateTime $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->productUseGuide = $productUseGuide;
        $this->imageUrl = $imageUrl;
        $this->discountPercent = $discountPercent;
        $this->updatedAt = $updatedAt;
    }

    public static function create(int $id, string $name, string $description, string $productUseGuide, string $imageUrl, string $discountPercent, DateTime $updatedAt): self
    {
        return new self($id, $name, $description, $productUseGuide, $imageUrl, $discountPercent, $updatedAt);
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

    public function getImageUrl(): string
    {
        return $this->imageUrl;
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

#[AsMessageHandler]
class UpdateProductCommandHandler
{
    private ProductRepository $productRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateProductCommand $command): void
    {
        $product = $this->productRepository->find($command->getId());

        if (!$product) {
            throw new \Exception('Product not found');
        }

        $product->setName($command->getName());
        $product->setDescription($command->getDescription());
        $product->setProductUseGuide($command->getProductUseGuide());
        $product->setImageUrl($command->getImageUrl());
        $product->setDiscountPercent($command->getDiscountPercent());
        $product->setUpdatedAt($command->getUpdatedAt());

        $this->entityManager->flush();
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
            ->add('imageUrl', TextType::class, [
                'label' => 'Image URL',
            ])
            ->add('discountPercent', TextType::class, [
                'label' => 'Discount Percent',
            ])
            ->add('updatedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Updated At',
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
?>
