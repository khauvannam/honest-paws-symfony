<?php

namespace App\Features\Carts\Handlers;

use App\Entity\Carts\Cart;
use App\Features\Carts\Queries\GetCartByCustomerIdQuery;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Repository\Carts\CartRepository;

class GetCartByCustomerIdHandler

{
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function __invoke(GetCartByCustomerIdQuery $query): ?Cart
    {
        return $this->cartRepository->find($query->getCustomerId());
    }
}
