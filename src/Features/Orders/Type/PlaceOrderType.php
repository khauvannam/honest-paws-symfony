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
                'label' => 'Địa chỉ giao hàng',
            ])
            ->add('shippingMethod', TextType::class, [
                'label' => 'Phương thức giao hàng',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Tiến hành đặt hàng',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlaceOrderCommand::class,
        ]);
    }
}