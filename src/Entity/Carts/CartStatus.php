<?php

namespace App\Entity\Carts;

enum CartStatus: string
{
    case preparing = 'preparing';
    case checkout = 'checkout';
}
