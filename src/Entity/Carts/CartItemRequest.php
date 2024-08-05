<?php

namespace App\Entity\Carts;

class CartItemRequest
{
private string $CartItemId;
private string $ProductId;
private string $VariantId;
private string $Name;
private int $Quantity;
private float $Price;
private string $ImageUrl;
private string $Description;

    public function getDescription(): string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): CartItemRequest
    {
        $this->Description = $Description;
        return $this;
    }
    public function getCartItemId(): string
    {
        return $this->CartItemId;
    }

    public function setCartItemId(string $CartItemId): CartItemRequest
    {
        $this->CartItemId = $CartItemId;
        return $this;
    }

    public function getProductId(): string
    {
        return $this->ProductId;
    }

    public function setProductId(string $ProductId): CartItemRequest
    {
        $this->ProductId = $ProductId;
        return $this;
    }

    public function getVariantId(): string
    {
        return $this->VariantId;
    }

    public function setVariantId(string $VariantId): CartItemRequest
    {
        $this->VariantId = $VariantId;
        return $this;
    }

    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $Name): CartItemRequest
    {
        $this->Name = $Name;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->Quantity;
    }

    public function setQuantity(int $Quantity): CartItemRequest
    {
        $this->Quantity = $Quantity;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): CartItemRequest
    {
        $this->Price = $Price;
        return $this;
    }

    public function getImageUrl(): string
    {
        return $this->ImageUrl;
    }

    public function setImageUrl(string $ImageUrl): CartItemRequest
    {
        $this->ImageUrl = $ImageUrl;
        return $this;
    }
}