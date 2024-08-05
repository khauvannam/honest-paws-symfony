<?php

namespace App\Features\Carts\Query;

class GetCartByCustomerId
{
    private string $customerId;

    public function __construct(string $customerId)
    {
        $this->customerId = $customerId;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }
}
