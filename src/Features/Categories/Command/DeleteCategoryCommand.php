<?php

namespace App\Features\Categories\Command;

class DeleteCategoryCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}