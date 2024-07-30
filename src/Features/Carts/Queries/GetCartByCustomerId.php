<?php

namespace App\Features\Carts\Queries;

class GetCartByCustomerIdQuery
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
