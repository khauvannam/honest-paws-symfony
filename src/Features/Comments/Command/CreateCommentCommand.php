<?php

declare(strict_types=1);

namespace App\Features\Comments\Command;

class CreateCommentCommand
{
    private string $productId = '';
    private string $userId = '';
    private string $content = '';

    public function __construct()
    {
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): CreateCommentCommand
    {
        $this->productId = $productId;
        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): CreateCommentCommand
    {
        $this->userId = $userId;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): CreateCommentCommand
    {
        $this->content = $content;
        return $this;
    }
}
