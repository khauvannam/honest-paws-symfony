<?php

namespace App\Features\Carts\Command;

use App\Entity\Carts\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CreateCartCommand
{
    private function __construct(string $CustomerId)
    {
        $this->CustomerId = $CustomerId;
    }

    private string $CustomerId;

    public static function Create(string $CustomerId): self
    {
        return new self($CustomerId);
    }

    public function getCustomerId(): string
    {
        return $this->CustomerId;
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
#[AsMessageHandler]
class CreateCartCommandHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateCartCommand $command): void
    {
        $cart = Cart::Create($command->getCustomerId());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }
}
