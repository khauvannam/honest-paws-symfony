<?php

namespace App\Twig;

use App\Entity\Carts\Cart;
use App\Entity\Carts\CartStatus;
use App\Entity\Users\User;
use App\Repository\Carts\CartRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CartExtension extends AbstractExtension
{


    public function __construct(private Security $security, private RequestStack $stack, private CartRepository $cartRepository)
    {

    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cart', [$this, 'getCart'])
        ];
    }

    public function getCart(): ?Cart
    {
        /**
         * @var User|null $user
         */
        $user = $this->security->getUser();
        $session = $this->stack->getSession();
        $customerId = $user ? $user->getId() : $this->getGuestSessionId($session);
        return $this->getCartOrThrowNull($customerId);
    }

    private function getGuestSessionId($session): ?string
    {
        return $session->get('customerId');
    }

    private function getCartOrThrowNull(?string $customerId): ?Cart
    {
        return $this->cartRepository->findOneBy([
            'customerId' => $customerId,
            'cartStatus' => CartStatus::preparing
        ]);
    }
}