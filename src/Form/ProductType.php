<?php

namespace App\Form;

use App\Entity\Products\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product Name',
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

?>
