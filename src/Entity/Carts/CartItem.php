<?php

namespace App\Entity\Carts;

use App\Repository\Carts\CartItemRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
class CartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private Uuid $id;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'cartItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cart $Cart;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getProductId(): string
    {
        return $this->ProductId;
    }

    public function getVariantId(): string
    {
        return $this->VariantId;
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

    public function getDescription(): string
    {
        return $this->Description;
    }

    public function getTotalPrice(): string
    {
        return $this->Price * $this->Quantity;
    }

    #[ORM\Column(length: 255)]
    private string $ProductId;

    #[ORM\Column(length: 255)]
    private string $VariantId;

    #[ORM\Column(length: 255)]
    private string $Name;

    #[ORM\Column(type: 'int')]
    private int $Quantity;

    #[ORM\Column]
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
        int    $quantity,
        float  $price,
        string $imgUrl,
        string $description,

    )
    {
        $this->id = Uuid::v4();
        $this->ProductId = $productId;
        $this->VariantId = $variantId;
        $this->Name = $name;
        $this->Quantity = $quantity;
        $this->Price = $price;
        $this->ImageUrl = $imgUrl;
        $this->Description = $description;
        $this->AddedAt = new DateTime();
    }

    public static function create(
        string $productId,
        string $variantId,
        string $name,
        int    $quantity,
        float  $price,
        string $imageUrl,
        string $description,

    ): self
    {
        return new self($productId, $variantId, $name, $quantity, $price, $imageUrl, $description);
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
