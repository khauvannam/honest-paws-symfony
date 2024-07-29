<?php

namespace App\Entity\Carts;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Carts\CartItemRepository;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
class CartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Cart::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $Cart;

    #[ORM\Column(length: 255)]
    private string $ProductId;

    #[ORM\Column(length: 255)]
    private string $VariantId;

    #[ORM\Column(length: 255)]
    private string $Name;

    #[ORM\Column(type: 'int')]
    private int $Quantity;

    #[ORM\Column()]
    private float $Price;

    #[ORM\Column(length: 255)]
    private string $ImageUrl;

    #[ORM\Column(type: 'datetime')]
    private DateTime $AddedAt;

    #[ORM\Column(length: 255)]
    private string $Description;

    #[ORM\Column(length: 255)]
    private string $TotalPrice;

    public function __construct(
        string $productId,
        string $variantId,
        string $name,
        int $quantity,
        float $price,
        string $imgUrl,
        string $description,

    ) {
        $this->ProductId = $productId;
        $this->VariantId = $variantId;
        $this->Name = $name;
        $this->Quantity = $quantity;
        $this->Price = $price;
        $this->ImageUrl = $imgUrl;
        $this->Description = $description;

        $this->AddedAt = new \DateTime();
    }

    public static function create(
        string $productId,
        string $variantId,
        string $name,
        int $quantity,
        float $price,
        string $imageUrl,
        string $description,
        string $basketId,

    ): self {
        return new self($productId, $variantId, $name, $quantity, $price, $imageUrl, $description, $basketId);
    }

    public function getCart(): ?Cart
    {
        return $this->Cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->Cart = $cart;
        return $this;
    }
}
