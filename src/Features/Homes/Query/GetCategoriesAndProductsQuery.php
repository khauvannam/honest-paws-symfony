<?php

namespace App\Features\Homes\Query;

class GetCategoriesAndProductsQuery
{
    private int $productLimit = 6;
    private int $categoryLimit = 4;

    public function __construct()
    {
    }

    public function getProductLimit(): int
    {
        return $this->productLimit;
    }

    public function setProductLimit(int $productLimit): GetCategoriesAndProductsQuery
    {
        $this->productLimit = $productLimit;
        return $this;
    }

    public function getCategoryLimit(): int
    {
        return $this->categoryLimit;
    }

    public function setCategoryLimit(int $categoryLimit): GetCategoriesAndProductsQuery
    {
        $this->categoryLimit = $categoryLimit;
        return $this;
    }
}