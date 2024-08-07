<?php

namespace App\Features\Categories\CommandHandler;

use App\Features\Categories\Command\UpdateCategoryCommand;
use App\Repository\Categories\CategoryRepository;
use App\Services\BlobService;
use Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateCategoryCommandHandler
{
    private CategoryRepository $categoryRepository;
    private BlobService $blobService;

    public function __construct(
        CategoryRepository $categoryRepository,
        BlobService        $blobService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->blobService = $blobService;
    }

    /**
     * @throws Exception
     */
    public function __invoke(UpdateCategoryCommand $command): void
    {
        $category = $this->categoryRepository->find($command->getId());

        if (!$category) {
            throw new Exception("Category not found");
        }

        if ($command->getImageFile() !== null) {
            $fileName = $this->blobService->upload($command->getImageFile());
            $this->blobService->delete($category->getImgUrl());
            $category->setImgUrl($fileName);
        }

        $category->update($command->getName(), $command->getDescription());

        $this->categoryRepository->update($category);
    }
}
