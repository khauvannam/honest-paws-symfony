<?php

namespace App\Features\Carts\Type;

use App\Command\UpdateCartCommand;
use App\Entity\Carts\CartItemRequest;
use App\Features\Carts\Command\UpdateCartCommand as CommandUpdateCartCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class, [
                'label' => 'Cart ID',
                'disabled' => true, // Assuming the cart ID should not be changed
            ])
            ->add('customerId', TextType::class, [
                'label' => 'Customer ID',
                'disabled' => true, // Assuming the customer ID should not be changed
            ])
            ->add('cartItems', CollectionType::class, [
                'entry_type' => CartItemRequest::class, // Assuming you have a form type for cart items
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandUpdateCartCommand::class,
        ]);
    }
}
