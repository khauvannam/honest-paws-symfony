<?php

namespace App\Features\Homes\Query;

class GetCategoriesAndProductsQuery
{
    private int $productLimit;
    private int $categoryLimit;
    private ?string $text;

    public function __construct(int $productLimit, int $categoryLimit, ?string $text )
    {
        $this->productLimit = $productLimit;
        $this->categoryLimit = $categoryLimit;
        $this->text = $text;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): GetCategoriesAndProductsQuery
    {
        $this->text = $text;
        return $this;
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