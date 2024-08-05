<?php

namespace App\Features\Categories\CommandHandler;

use App\Entity\Categories\Category;
use App\Features\Categories\Command\CreateCategoryCommand;
use App\Repository\Categories\CategoryRepository;
use App\Services\BlobService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateCategoryCommandHandler
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository, private readonly BlobService $blobService)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(CreateCategoryCommand $command): void
    {
        $fileName = $this->blobService->upload($command->getUploadedFile());
        $category = Category::create($command->getName(), $command->getDescription(), $fileName);
        $this->categoryRepository->save($category);

    }
}