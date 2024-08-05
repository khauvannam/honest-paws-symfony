<?php

namespace App\Features\Categories\QueryHandler;

use App\Features\Categories\Query\GetAllCategoryQuery;
use App\Interfaces\QueryHandlerInterface;
use App\Repository\Categories\CategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
#[AsMessageHandler]
class GetAllCategoryQueryHandler 
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function __invoke(GetAllCategoryQuery $allCategoryQuery) : array
    {
        return $this->categoryRepository->findAll();
    }
}