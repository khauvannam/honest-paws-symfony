<?php

namespace App\Features\Products\Type;

use App\Features\Products\Command\CreateProductCommand;
use App\Repository\Categories\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateProductType extends AbstractType
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array                $options
    ): void
    {
        $categories = $this->categoryRepository->findAll();
        $categoryChoices = [];
        foreach ($categories as $category) {
            $categoryChoices[$category->getName()] = $category->getId();
        }

        $builder
            ->add("name", TextType::class, [
                "label" => "Name",
            ])
            ->add("quantity", NumberType::class, [
                "label" => "Quantity",
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
            ->add("price", NumberType::class, ["label" => "Price"])
            ->add("discountPercent", NumberType::class, [
                "label" => "Discount Percent",
            ])
            ->add("categoryId", ChoiceType::class, [
                "label" => "Choose Category",
                "choices" => $categoryChoices,
            ])
            ->add("save", SubmitType::class, [
                "label" => "Lưu Sản Phẩm",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => CreateProductCommand::class,
        ]);
    }
}
