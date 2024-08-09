<?php

namespace App\Entity\Carts;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
class CartItem
{
    #[ORM\Id]
    #[ORM\Column]
    private string $id;

    #[ORM\Column(length: 255)]
    private string $productId;

    #[ORM\Column(length: 255)]
    private string $Name;

    #[ORM\Column]
    private int $quantity;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(length: 255)]
    private string $imageUrl;

    #[ORM\Column(type: 'datetime')]
    private DateTime $addedAt;

    #[ORM\Column]
    private string $TotalPrice;
    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'cartItems')]
    private Cart $cart;

    public function __construct(
        string $productId,
        string $name,
        int    $quantity,
        float  $price,
        string $imgUrl,
    )
    {
        $this->id = Uuid::v4()->toString();
        $this->productId = $productId;
        $this->Name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->imageUrl = $imgUrl;
        $this->addedAt = new DateTime();
        $this->TotalPrice = $this->price * $this->quantity;
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
        $this->quantity = $quantity;
        $this->price = $price;
        $this->imageUrl = $imageUrl;

    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): CartItem
    {
        $this->cart = $cart;
        return $this;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }


    public function getName(): string
    {
        return $this->Name;
    }

    public function setName(string $name): self
    {
        $this->Name = $name;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        $this->TotalPrice = $this->price * $quantity;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        $this->TotalPrice = $price * $this->quantity;
        return $this;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    public function getAddedAt(): DateTime
    {
        return $this->addedAt;
    }

    public function setAddedAt(DateTime $addedAt): self
    {
        $this->addedAt = $addedAt;
        return $this;
    }

    public function getTotalPrice(): string
    {
        return $this->TotalPrice;
    }
}
