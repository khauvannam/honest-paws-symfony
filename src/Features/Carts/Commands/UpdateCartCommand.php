<?php

namespace App\Features\Carts\Commands;

use App\Entity\Carts\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateCartCommand
{
    private ?int $cartId;
    private string $customerId;

    public function __construct(string $customerId, ?int $cartId = null)
    {
        $this->cartId = $cartId;
        $this->customerId = $customerId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getCartId(): ?int
    {
        return $this->cartId;
    }
}

class CreateUpdateCartHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UpdateCartCommand $command)
    {
        $cartId = $command->getCartId();
        $cart = null;

        if ($cartId) {
            $cart = $this->entityManager->getRepository(Cart::class)->find($cartId);
            if (!$cart) {
                throw new \Exception('Cart not found');
            }
        }

        if (!$cart) {
            $cart = Cart::Create($command->getCustomerId());
        } else {
            $cart->Update($command->getCustomerId());
        }

        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }
}

class CartFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customerId', TextType::class, [
                'label' => 'Customer ID',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Cart',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateCartCommand::class,
        ]);
    }
}
