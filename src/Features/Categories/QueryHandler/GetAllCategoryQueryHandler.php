<?php

namespace App\Features\Categories\QueryHandler;

use App\Repository\Products\Categories\CategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetAllCategoryQueryHandler
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function __invoke() : array
    {
        return $this->categoryRepository->findAll();
    }
}