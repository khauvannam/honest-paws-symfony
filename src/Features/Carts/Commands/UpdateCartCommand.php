<?php

namespace App\Features\Carts\Commands;

use App\Entity\Carts\Cart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Uid\Uuid;


class UpdateCartCommand
{
    private Uuid $cartId;
    private string $customerId;

    private function __construct(string $customerId, Uuid $cartId = null)
    {
        $this->cartId = $cartId;
        $this->customerId = $customerId;

    }

    public static function Create(string $customerId, ?int $cartId = null): self
    {
        return new self($customerId, $cartId);
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function getCartId(): Uuid
    {
        return $this->cartId;
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
            'data_class' => CreateUpdateCartCommand::class,
        ]);
    }
}

class CreateUpdateCartHandler
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(CreateUpdateCartCommand $command)
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
