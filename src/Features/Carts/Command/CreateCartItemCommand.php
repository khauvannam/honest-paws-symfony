<?php

namespace App\Features\Carts\Command;

class CreateCartItemCommand
{
    private string $productId = '';
    private int $quantity = 1;
    private string $imgUrl = '';
    private string $name = '';
    private float $price = 0;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CreateCartItemCommand
    {
        $this->name = $name;
        return $this;
    }

    public function getProductPrice(): int
    {
        return $this->productPrice;
    }

    public function setProductPrice(int $productPrice): CreateCartItemCommand
    {
        $this->productPrice = $productPrice;
        return $this;
    }

    private int $productPrice = 0;

    public function __construct()
    {
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): void
    {
        $this->imgUrl = $imgUrl;
    }

    public function getProductName(): string
    {
        return $this->name;
    }

    public function setProductName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}