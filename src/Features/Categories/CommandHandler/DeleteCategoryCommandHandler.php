<?php

namespace App\Features\Categories\CommandHandler;


use App\Features\Categories\Command\DeleteCategoryCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Categories\CategoryRepository;

class DeleteCategoryCommandHandler implements CommandHandlerInterface
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