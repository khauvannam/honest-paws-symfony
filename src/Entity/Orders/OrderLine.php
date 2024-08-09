<?php

namespace App\Entity\Orders;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class OrderLine
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\ManyToOne(targetEntity: OrderBase::class, inversedBy: 'orderLines')]
    private OrderBase $order;

    #[ORM\Column(type: "string", length: 255)]
    private string $productId;

    #[ORM\Column(type: "string", length: 255)]
    private string $productName;
    #[ORM\Column(type: "string", length: 255)]
    private string $imgUrl;

    #[ORM\Column]
    private int $quantity;

    #[ORM\Column(type: "decimal", scale: 2)]
    private float $price;

    public function __construct(
        string $productId,
        string $productName,
        string $imgUrl,
        int    $quantity,
        float  $price
    )
    {
        $this->id = Uuid::v4()->toString();
        $this->productId = $productId;
        $this->productName = $productName;
        $this->imgUrl = $imgUrl;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(string $imgUrl): OrderLine
    {
        $this->imgUrl = $imgUrl;
        return $this;
    }

    // Getters and setters...

    public function getId(): string
    {
        return $this->id;
    }

    public function getOrder(): OrderBase
    {
        return $this->order;
    }

    public function setOrder(OrderBase $order): void
    {
        $this->order = $order;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getTotal(): float
    {
        return $this->quantity * $this->price;
    }

}
