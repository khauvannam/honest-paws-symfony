<?php
namespace App\Features\Products\Type;

use App\Features\Products\Command\CreateProductCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProductType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add("name", TextType::class, [
                "label" => "Name",
            ])
            ->add("description", TextType::class, [
                "label" => "Description",
            ])
            ->add("productUseGuide", TextType::class, [
                "label" => "Product Use Guide",
            ])
            ->add("imgFile", FileType::class, [
                "label" => "Image (JPEG, PNG file)",
                "mapped" => false,
                "required" => true,
            ])
            ->add("discountPercent", NumberType::class, [
                "label" => "Discount Percent",
            ])
            ->add("save", SubmitType::class, [
                "label" => "Save",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => CreateProductCommand::class,
        ]);
    }
}
