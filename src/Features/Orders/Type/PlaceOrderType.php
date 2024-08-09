<?php

namespace App\Features\Orders\Type;

use App\Features\Orders\Command\PlaceOrderCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shippingAddress', TextType::class, [
                'label' => 'Shipping Address',
            ])
            ->add('shippingMethod', TextType::class, [
                'label' => 'Shipping Method',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Place Order',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlaceOrderCommand::class,
        ]);
    }
}