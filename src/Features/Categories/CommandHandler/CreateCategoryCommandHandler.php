<?php

namespace App\Features\Categories\CommandHandler;


use App\Entity\Categories\Category;
use App\Features\Categories\Command\CreateCategoryCommand;
use App\Interfaces\CommandHandlerInterface;
use App\Repository\Categories\CategoryRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class CreateCategoryCommandHandler implements CommandHandlerInterface
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(CreateCategoryCommand $command) : void
    {
        $category = Category::create($command->getName(), $command->getDescription());
        $this->categoryRepository->save($category);

    }
}