<?php

namespace App\Features\Comments\Command;

class UpdateCommentCommand
{
    private string $id;
    private string $content;

    public function __construct()
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): UpdateCommentCommand
    {
        $this->content = $content;
        return $this;
    }
}