<?php

namespace App\Features\Categories\QueryHandler;

use App\Entity\Categories\Category;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FindCategoryByIdQueryHandler
{

    public function __construct()
    {
    }

    public function __invoke() : Category
    {
        // TODO: Implement __invoke() method.
    }
}