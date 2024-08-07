<?php

namespace App\Entity\Carts;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class CartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $ProductId;

    #[ORM\Column(length: 255)]
    private string $Name;
    #[ORM\Column]
    private int $Quantity;

    #[ORM\Column]
    private float $Price;

    #[ORM\Column(length: 255)]
    private string $ImageUrl;

    #[ORM\Column(type: "datetime")]
    private DateTime $AddedAt;

    #[ORM\Column]
    private string $TotalPrice;

    public function __construct(
        string $productId,
        string $name,
        int    $quantity,
        float  $price,
        string $imgUrl,
    )
    {
        $this->id = Uuid::v4()->toString();
        $this->ProductId = $productId;
        $this->Name = $name;
        $this->Quantity = $quantity;
        $this->Price = $price;
        $this->ImageUrl = $imgUrl;
        $this->AddedAt = new DateTime();
        $this->TotalPrice = $this->Price * $this->Quantity;
    }

    public static function create(
        string $productId,
        string $name,
        int    $quantity,
        float  $price,
        string $imageUrl,
    ): self
    {
        return new self(
            $productId,
            $name,
            $quantity,
            $price,
            $imageUrl,
        );
    }

    public function update(
        $name,
        $quantity,
        $price,
        $imageUrl,
    ): void
    {
        $this->Name = $name;
        $this->Quantity = $quantity;
        $this->Price = $price;
        $this->ImageUrl = $imageUrl;

    }

    public function getCartItemId(): string
    {
        return $this->id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProductId(): string
    {
        return $this->ProductId;
    }


    public function getName(): string
    {
        return $this->Name;
    }

    public function getQuantity(): int
    {
        return $this->Quantity;
    }

    public function getPrice(): float
    {
        return $this->Price;
    }

    public function getImageUrl(): string
    {
        return $this->ImageUrl;
    }

    public function getAddedAt(): DateTime
    {
        return $this->AddedAt;
    }

    public function getTotalPrice(): string
    {
        return $this->TotalPrice;
    }
}
