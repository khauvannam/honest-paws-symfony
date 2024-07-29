<?php

namespace App\Features\Products;

use App\Entity\Products\OriginalPrice;
use App\Entity\Products\ProductVariant;
use App\Repository\ProductVariantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateProductVariantCommand
{
    private int $id;
    private string $variantName;
    private int $quantity;
    private float $originalPrice;
    private float $discountedPrice;

    public function __construct(int $id, string $variantName, int $quantity, float $originalPrice, float $discountedPrice)
    {
        $this->id = $id;
        $this->variantName = $variantName;
        $this->quantity = $quantity;
        $this->originalPrice = $originalPrice;
        $this->discountedPrice = $discountedPrice;
    }

    public static function create(int $id, string $variantName, int $quantity, float $originalPrice, float $discountedPrice): self
    {
        return new self($id, $variantName, $quantity, $originalPrice, $discountedPrice);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getVariantName(): string
    {
        return $this->variantName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getOriginalPrice(): float
    {
        return $this->originalPrice;
    }

    public function getDiscountedPrice(): float
    {
        return $this->discountedPrice;
    }
}

#[AsMessageHandler]
class UpdateProductVariantCommandHandler
{
    private EntityManagerInterface $entityManager;
    private ProductVariantRepository $productVariantRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductVariantRepository $productVariantRepository)
    {
        $this->entityManager = $entityManager;
        $this->productVariantRepository = $productVariantRepository;
    }

    public function __invoke(UpdateProductVariantCommand $command): void
    {
        $productVariant = $this->productVariantRepository->find($command->getId());

        if (!$productVariant) {
            throw new \Exception('Product variant not found');
        }

        $originalPrice = OriginalPrice::create($command->getOriginalPrice());

        $productVariant->setVariantName($command->getVariantName());
        $productVariant->setQuantity($command->getQuantity());
        $productVariant->setOriginalPrice($originalPrice);
        $productVariant->setDiscountedPrice($command->getDiscountedPrice());

        $this->entityManager->flush();
    }
}

class UpdateProductVariantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', NumberType::class, [
                'label' => 'ID',
                'disabled' => true,
            ])
            ->add('variantName', TextType::class, [
                'label' => 'Variant Name',
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Quantity',
            ])
            ->add('originalPrice', NumberType::class, [
                'label' => 'Original Price',
            ])
            ->add('discountedPrice', NumberType::class, [
                'label' => 'Discounted Price',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateProductVariantCommand::class,
        ]);
    }
}
?>
