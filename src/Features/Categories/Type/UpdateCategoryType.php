<?php

namespace App\Features\Categories\Type;

use App\Features\Categories\Command\UpdateCategoryCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('name', TextType::class, [
                'label' => 'Category Name',
            ])
            ->add('description', TextType::class, [
                'label' => 'Category Description',
            ])
            ->add("imageFile", FileType::class, [
                "label" => "Image URL",
            ])
            ->add("save", SubmitType::class, [
                "label" => "Update",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateCategoryCommand::class,
        ]);
    }
}