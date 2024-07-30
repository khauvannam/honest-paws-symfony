<?php

namespace App\Features\Carts\Command\Handlers;

use App\Entity\Carts\Cart;
use App\Features\Carts\Command\Queries\GetCartByCustomerIdQuery;
use App\Repository\Carts\CartRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

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
