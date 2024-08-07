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
    #[ORM\Column(type: 'uuid')]
    private string $id;

<<<<<<< HEAD
    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'cartItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cart $cart;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

=======
>>>>>>> origin/namdeptrai
    #[ORM\Column(length: 255)]
    private string $productId;

    #[ORM\Column(length: 255)]
<<<<<<< HEAD
    private string $name;
=======
    private string $Name;
    #[ORM\Column]
    private int $Quantity;
>>>>>>> origin/namdeptrai

    #[ORM\Column]
    private int $quantity;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(length: 255)]
    private string $imageUrl;

    #[ORM\Column(type: 'datetime')]
    private DateTime $addedAt;

<<<<<<< HEAD
    #[ORM\Column(length: 255)]
    private string $description;

    #[ORM\Column(type: 'float')]
    private float $totalPrice;
=======
    #[ORM\Column]
    private string $TotalPrice;
>>>>>>> origin/namdeptrai

    public function __construct(
        string $productId,
        string $name,
<<<<<<< HEAD
        int $quantity,
        float $price,
        string $imageUrl,
        string $description
    )
    {
        $this->id = Uuid::v4()->toString();
        $this->productId = $productId;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->description = $description;
        $this->addedAt = new DateTime();
        $this->totalPrice = $price * $quantity;
=======
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
>>>>>>> origin/namdeptrai
    }

    public static function create(
        string $productId,
        string $name,
        int $quantity,
        float $price,
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
<<<<<<< HEAD
        string $name,
        int $quantity,
        float $price,
        string $imageUrl,
        string $description
    ): void
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->description = $description;
        $this->totalPrice = $price * $quantity;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;
        return $this;
    }

    public function getProduct(): Product
=======
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
>>>>>>> origin/namdeptrai
    {
        return $this->product;
    }

<<<<<<< HEAD
    public function setProduct(Product $product): self
    {
        $this->product = $product;
        return $this;
    }

=======
>>>>>>> origin/namdeptrai
    public function getId(): string
    {
        return $this->id;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

<<<<<<< HEAD
    public function setProductId(string $productId): self
    {
        $this->productId = $productId;
        return $this;
    }
=======
>>>>>>> origin/namdeptrai

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        $this->totalPrice = $this->price * $quantity;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        $this->totalPrice = $price * $this->quantity;
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

<<<<<<< HEAD
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
=======
    public function getTotalPrice(): string
    {
        return $this->TotalPrice;
>>>>>>> origin/namdeptrai
    }
}
