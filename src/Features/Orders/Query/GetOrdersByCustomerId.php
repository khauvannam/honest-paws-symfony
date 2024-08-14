<?php

namespace App\Features\Orders\Query;

class GetOrdersByCustomerId
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
