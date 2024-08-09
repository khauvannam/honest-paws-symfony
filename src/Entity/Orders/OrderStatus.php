<?php

namespace App\Entity\Orders;

enum OrderStatus: string
{
    case pending = 'pending';
    case shipping = 'shipping';
    case delivered = 'delivered';

}
