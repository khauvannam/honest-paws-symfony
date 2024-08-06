<?php

namespace App\Features\Products\Query;

class GetProductByCategoryIDQuery
{
    private string $categoryId;

    public function __construct(string $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }
}
