<?php

namespace App\Features\Categories\CommandHandler;

use App\Features\Categories\Command\UpdateCategoryCommand;
use App\Repository\Categories\CategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCategoryCommandHandler
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(UpdateCategoryCommand $command): void
    {
        $category = $this->categoryRepository->find($command->id);
        if ($category) {
            $category->update($command->name, $command->description);
            $this->categoryRepository->save($category);
        }
    }
}