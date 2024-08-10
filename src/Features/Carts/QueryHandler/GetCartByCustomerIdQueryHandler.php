<?php

namespace App\Features\Carts\QueryHandler;

use App\Entity\Carts\Cart;
use App\Entity\Carts\CartStatus;
use App\Entity\Users\User;
use App\Features\Carts\Query\GetCartByCustomerId;
use App\Repository\Carts\CartRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetCartByCustomerIdQueryHandler
{
    private CartRepository $cartRepository;
    private Security $security;
    private RequestStack $stack;

    public function __construct(CartRepository $cartRepository, Security $security, RequestStack $requestStack)
    {
        $this->cartRepository = $cartRepository;
        $this->security = $security;
        $this->stack = $requestStack;
    }

    public function __invoke(GetCartByCustomerId $query): ?Cart
    {
        /**
         * @var User $user
         */
        $user = $this->security->getUser();
        $session = $this->stack->getSession();
        $customerId = $user ? $user->getId() : $session->get('customerId');

        return $this->cartRepository->findOneBy(['customerId' => $customerId, 'cartStatus' => CartStatus::preparing]);
    }
}
