<?php

namespace App\Features\Comments\Type;

use App\Features\Comments\Command\CreateCommentCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productId', HiddenType::class, [
                'label' => 'Product ID',
            ])
            ->add('userId', HiddenType::class, [
                'label' => 'User ID',
            ])
            ->add('content', TextType::class, [
                'label' => 'Content',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateCommentCommand::class,
        ]);
    }
}