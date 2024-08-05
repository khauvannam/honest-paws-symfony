<?php

namespace App\Features\Products\Command;

class DeleteProductCommand
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function create(int $id): self
    {
        return new self($id);
    }

    public function getId(): int
    {
        return $this->id;
    }
}



