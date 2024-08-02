<?php

namespace App\Services;

use RuntimeException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BlobService
{
    private string $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file): string
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        try {
            $file->move($this->targetDirectory, $fileName);
        } catch (FileException $e) {
            // Handle exception if something happens during file upload
            throw new RuntimeException('Could not upload file.' . $e);
        }

        return $fileName;
    }

    public function delete(string $fileName): void
    {
        $filePath = $this->targetDirectory . '/' . $fileName;

        if (file_exists($filePath)) {
            if (!unlink($filePath)) {
                throw new RuntimeException('Could not delete file.');
            }
        } else {
            throw new RuntimeException('File does not exist.');
        }
    }
}