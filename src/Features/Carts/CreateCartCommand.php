<?php

namespace App\Features\Carts;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;



class CreateCartCommand
{
    private function __construct(string $customerId)
    {
        $this->customerId = $customerId;
    }

    private string $customerId;

    public static function Create(string $customerId): self
    {
        return new self($customerId);
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
            ->add('customerId', TextType::class, [
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
class CreateCartCommandHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateCartCommand $command)
    {
        $cart = new Cart();
        $cart->setCustomerId($command->getCustomerId());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }
}
