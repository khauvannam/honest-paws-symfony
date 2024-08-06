<?php

namespace App\Features\Categories\Type;

use App\Features\Categories\Command\CreateCategoryCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CreateCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Category Name',
            ])
            ->add('description', TextType::class, [
                'label' => 'Category Description',
            ])
            ->add('uploadedFile', FileType::class, [
                'label' => 'Image (JPEG, PNG file)',
                'required' => true,
            ])
            ->add("save", SubmitType::class, [
                "label" => "Save",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateCategoryCommand::class,
        ]);
    }
}