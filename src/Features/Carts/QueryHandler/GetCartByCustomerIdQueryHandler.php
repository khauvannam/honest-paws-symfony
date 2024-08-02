<?php

namespace App\Features\Carts\QueryHandler;

use App\Entity\Carts\Cart;
use App\Features\Carts\Query\GetCartByCustomerId;
use App\Interfaces\QueryHandlerInterface;
use App\Repository\Carts\CartRepository;

class GetCartByCustomerIdQueryHandler implements QueryHandlerInterface
{
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function __invoke(GetCartByCustomerId $query): ?Cart
    {
        return $this->cartRepository->find($query->getCustomerId());
    }
}
