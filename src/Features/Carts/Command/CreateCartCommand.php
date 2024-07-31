<?php

namespace App\Features\Carts\Command;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateCartCommand
{
    private string $customerId;
    private function __construct(string $customerId)
    {
        $this->customerId = $customerId;
    }

    public static function Create(string $CustomerId): self
    {
        return new self($CustomerId);
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }
}

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CustomerId', TextType::class, [
                'label' => 'Customer ID',
            ])
            ->add('createCart', SubmitType::class, [
                'label' => 'Create Cart',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateCartCommand::class,
        ]);
    }
}
