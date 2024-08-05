<?php

namespace App\Features\Categories\Command;


class UpdateCategoryCommand
{
    public string $id;
    public string $name;
    public string $description;

    public function __construct(string $id)
    {
      $this->id = $id; 
    }
}


