<?php

namespace App\Features\Categories\Command;

use Symfony\Component\Uid\Uuid;

class UpdateCategoryCommand
{
    public Uuid $id;
    public string $name;
    public string $description;

    public function __construct(Uuid $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }
}


