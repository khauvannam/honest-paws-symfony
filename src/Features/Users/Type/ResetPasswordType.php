<?php

namespace App\Features\Users\Type;

use App\Features\Users\Command\ResetPasswordCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', TextType::class, [
                'label' => 'New password',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Request Password Reset',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResetPasswordCommand::class,
        ]);
    }
}