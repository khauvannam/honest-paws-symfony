<?php

namespace App\Features\Categories\QueryHandler;

use App\Entity\Categories\Category;
use App\Features\Categories\Query\FindCategoryByIdQuery;
use PHPUnit\TextUI\CliArguments\Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class FindCategoryByIdQueryHandler
{

    public function __construct()
    {
    }

    public function __invoke(FindCategoryByIdQuery $query): Category
    {
        throw new Exception();
    }
}