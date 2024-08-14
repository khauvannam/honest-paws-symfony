<?php


namespace App\Features\Users\Type;

use App\Features\Users\Command\ResetPasswordVerifyCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordVerifyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('token', TextType::class, [
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Request Password Reset',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => ResetPasswordVerifyCommand::class,
        ]);
    }
}
