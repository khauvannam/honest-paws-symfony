<?php

namespace App\Features\Carts\Type;

use App\Features\Carts\Command\CreateCartItemCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateCartItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productId', HiddenType::class, [
                'label' => 'Product ID',
            ])
            ->add('quantity', HiddenType::class, [
                'label' => 'Quantity',
            ])
            ->add('imgUrl', HiddenType::class, [
                'label' => 'Image URL',
            ])
            ->add('name', HiddenType::class, [
                'label' => 'Product Name',
            ])
            ->add('price', HiddenType::class, [
                'label' => 'Product Price',
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateCartItemCommand::class,
        ]);
    }
}