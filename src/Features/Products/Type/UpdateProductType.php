<?php

namespace App\Features\Products\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateProductType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add("id", TextType::class, [
                "label" => "ID",
                "disabled" => true,
            ])
            ->add("name", TextType::class, [
                "label" => "Name",
            ])
            ->add("description", TextType::class, [
                "label" => "Description",
            ])
            ->add("productUseGuide", TextType::class, [
                "label" => "Product Use Guide",
            ])
            ->add("imageFile", FileType::class, [
                "label" => "Image URL",
            ])
            ->add("discountPercent", TextType::class, [
                "label" => "Discount Percent",
            ])
            ->add("save", SubmitType::class, [
                "label" => "Update",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => UpdateProductCommand::class,
        ]);
    }
}
