<?php

namespace App\Features\Categories\CommandHandler;


use App\Features\Categories\Command\DeleteCategoryCommand;
use App\Repository\Categories\CategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeleteCategoryCommandHandler
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $category = $this->categoryRepository->find($command->id);
        if ($category) {
            $this->categoryRepository->delete($category);
        }
    }
}