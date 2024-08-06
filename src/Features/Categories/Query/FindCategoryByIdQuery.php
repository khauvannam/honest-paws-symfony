<?php

namespace App\Features\Categories\Query;

class FindCategoryByIdQuery
{
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): FindCategoryByIdQuery
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

}