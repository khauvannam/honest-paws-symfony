<?php

namespace App\Features\Categories\Command;


use Symfony\Component\Uid\Uuid;

class DeleteCategoryCommand
{
    public Uuid $id;

    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }
}